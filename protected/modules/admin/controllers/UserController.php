<?php

class UserController extends AdminController
{
    public function filters()
    {
        return array(
            'postOnly + setVerify',
            'ajaxOnly + setVerify',
        );
    }
    
	public function actionIndex()
	{
		$this->render('index');
	}
	
	public function actionVerify()
	{
	    $criteria = new CDbCriteria();
	    $criteria->addColumnCondition(array('state'=>USER_STATE_UNVERIFY));
	    $data = AdminUser::fetchList($criteria);
	     
	    $this->adminTitle = t('verify_user', 'admin');
	    $this->render('list', $data);
	}
	
	public function actionToday()
	{
	    $time = $_SERVER['REQUEST_TIME'] - 24*60*60;
	    $criteria = new CDbCriteria();
	    $criteria->addCondition('create_time > ' . $time);
	    $data = AdminUser::fetchList($criteria);
	    
	    $this->adminTitle = t('today_signup_user', 'admin');
	    
	    $this->render('list', $data);
	}
	
	
	public function actionList()
	{
	    $criteria = new CDbCriteria();
	    $data = AdminUser::fetchList($criteria);
	    
	    $this->adminTitle = t('user_account_list', 'admin');
	    
	    $this->render('list', $data);
	}
	
	public function actionCreate($id = 0)
	{
	    $id = (int)$id;
	    if ($id === 0) {
	        $model = new AdminUser();
	        $this->adminTitle = t('create_user', 'admin');
	    }
	    else {
	        $model = AdminUser::model()->findByPk($id);
	        $this->adminTitle = t('edit_user', 'admin') . ' - ' . $model->name;
	    }
	    
	    if (request()->getIsPostRequest() && isset($_POST['AdminUser'])) {
	        $model->attributes = $_POST['AdminUser'];
	        
	        $attributes = $model->getAttributes();
	        if ($model->getIsNewRecord())
    	        $model->encryptPassword();
	        else
	            unset($attributes['password']);
	        
	        if ($model->save()) {
	            user()->setFlash('user_create_result', t('user_create_success', 'admin', array('{name}'=>$model->email)));
	            $this->redirect(request()->getUrl());
	        }
	    }
	    
	    $view = $model->getIsNewRecord() ? 'create' : 'edit';
	    $this->render($view, array(
	        'model' => $model,
	        'userStates' => $userStates,
	    ));
	}
	
	public function actionSearch()
	{
	    $form = new UserSearchForm();
	    
	    if (isset($_GET['UserSearchForm'])) {
	        $form->attributes = $_GET['UserSearchForm'];
	        if ($form->validate())
	            $data = $form->search();
	        user()->setFlash('table_caption', t('user_search_result', 'admin'));
	    }
	    
        $this->render('search', array('form'=>$form, 'data'=>$data));
	}

	public function actionSetVerify($id, $callback)
	{
	    $id = (int)$id;
	    $model = AdminUser::model()->findByPk($id);
	    if ($model === null)
	        throw new CHttpException(500);
	     
	    $model->state = ($model->state == USER_STATE_ENABLED) ? USER_STATE_FORBIDDEN : USER_STATE_ENABLED;
	    $model->save(true, array('state'));
	    if ($model->hasErrors())
	        throw new CHttpException(500);
	    else {
	        if ($model->state == USER_STATE_ENABLED)
	            $text = 'user_enabled';
	        elseif ($model->state == USER_STATE_FORBIDDEN)
    	        $text = 'user_forbidden';

	        $data = array(
	            'errno' => BETA_NO,
	            'label' => t($text, 'admin')
	        );
	        BetaBase::jsonp($callback, $data);
	        exit(0);
	    }
	}

	public function actionResetPassword($id)
	{
	    $id = (int)$id;
	    if ($id <= 0)
	        throw new CHttpException(500);
	    
	    $criteria = new CDbCriteria();
	    $criteria->select = array('id', 'email', 'name', 'password');
	    $user = AdminUser::model()->findByPk($id, $criteria);
	    if ($user === null)
	        throw new CHttpException(404, t('user_is_not_exist', 'admin'));
	    
	    if (request()->getIsPostRequest() && isset($_POST['AdminUser'])) {
	        $user->attributes = $_POST['AdminUser'];
	        $user->encryptPassword();
	        if ($user->save(true, array('password'))) {
	            user()->setFlash('user_create_result', t('user_resetpwd_success', 'admin', array('{name}'=>$user->email)));
	            $this->redirect(request()->getUrl());
	        }
	    }
	    
	    $user->password = '';
	    $this->adminTitle = t('reset_user_passwd', 'admin') . ' - ' . $user->name;
	    $this->render('resetpwd', array('model'=>$user));
	}

    public function actionCurrent()
    {
        $this->forward('info');
    }
    
    public function actionInfo($id = 0)
    {
        $id = (int)$id;
        $userID = ($id > 0) ? $id : (int)user()->id;
        $model = AdminUser::model()->findByPk($userID);
        if ($model === null)
            throw new CHttpException(500, t('user_is_not_exist', 'admin'));
        
        $this->adminTitle = $model->name;
        $this->render('info', array('model' => $model));
    }


    /**
     * 批量审核用户
     * @param array $ids 用户ID数组
     * @param string $callback jsonp回调函数，自动赋值
     */
    public function actionMultiVerify($callback)
    {
        $ids = (array)request()->getPost('ids');
    
        $successIds = $failedIds = array();
        $attributes = array(
            'state' => USER_STATE_ENABLED,
        );
        foreach ($ids as $id) {
            $result = AdminUser::model()->updateByPk($id, $attributes);
            if ($result)
                $successIds[] = $id;
            else
                $failedIds[] = $id;
        }
        $data = array(
            'success' => $successIds,
            'failed' => $failedIds,
            'label' => t('user_enabled', 'admin'),
        );
        BetaBase::jsonp($callback, $data);
    }
    
    /**
     * 批量禁用用户
     * @param array $ids 用户ID数组
     * @param string $callback jsonp回调函数，自动赋值
     */
    public function actionMultiForbidden($callback)
    {
        $ids = (array)request()->getPost('ids');
    
        $successIds = $failedIds = array();
        $attributes = array(
            'state' => USER_STATE_FORBIDDEN,
        );
        foreach ($ids as $id) {
            $result = AdminUser::model()->updateByPk($id, $attributes);
            if ($result)
                $successIds[] = $id;
            else
                $failedIds[] = $id;
        }
        $data = array(
            'success' => $successIds,
            'failed' => $failedIds,
            'label' => t('user_forbidden', 'admin'),
        );
        BetaBase::jsonp($callback, $data);
    }
}