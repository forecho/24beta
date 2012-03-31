<?php

class UserController extends AdminController
{
    public function filters()
    {
        return array(
            'onlyPost + setVerify',
            'onlyAjax + setVerify',
        );
    }
    
	public function actionIndex()
	{
		$this->render('index');
	}
	
	public function actionVerify()
	{
	    $criteria = new CDbCriteria();
	    $criteria->addColumnCondition(array('state'=>AdminUser::STATE_DISABLED));
	    $data = AdminUser::fetchList($criteria);
	     
	    $this->adminTitle = t('verify_user', 'admin');
	    $this->render('list_no_verify', $data);
	}
	
	public function actionMostActive()
	{
	    // @todo adminTitle
	    $this->adminTitle = t('verify_user', 'admin');
	    $this->render('list', $data);
	}
	
	public function actionToday()
	{
	    $time = $_SERVER['REQUEST_TIME'] - 24*60*60;
	    $criteria = new CDbCriteria();
	    $criteria->addCondition('create_time > ' . $time);
	    $data = AdminUser::fetchList($criteria);
	    
	    $this->adminTitle = t('today_signup', 'admin');
	    
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
	        $this->adminTitle = t('edit_user', 'admin');
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
	
	public function actionEdit($id)
	{
	    $this->render('edit', array('model'=>$model));
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
	     
	    $model->state = abs($model->state - AdminUser::STATE_ENABLED);
	    $model->save(true, array('state'));
	    if ($model->hasErrors())
	        throw new CHttpException(500);
	    else {
	        $data = array(
	            'errno' => BETA_NO,
	            'label' => t($model->state == AdminUser::STATE_DISABLED ? 'setshow' : 'sethide', 'admin')
	        );
	        echo $callback . '(' . CJSON::encode($data) . ')';
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
	    $this->adminTitle = t('reset_user_passwd', 'admin');
	    $this->render('resetpwd', array('model'=>$user));
	}

    public function actionStatistics()
    {
        echo __METHOD__;
    }
}