<?php

class PostController extends AdminController
{
    public function filters()
    {
        return array(
            'ajaxOnly + setVerify, quickUpdate, setDelete, setTrash, multiTrash, multiDelete, multiVerify, multiReject, multiRecommend, multiHottest',
            'postOnly + setVerify, quickUpdate, setDelete, setTrash, multiTrash,, multiDelete, multiVerify, multiReject, multiRecommend, multiHottest',
        );
    }
    
	public function actionCreate($id = 0)
	{
	    $id = (int)$id;
	    if ($id === 0) {
	        $model = new AdminPost();
	        $model->homeshow = user()->checkAccess('create_post_in_home') ? BETA_YES : BETA_NO;
	        $model->state = BETA_YES;
	        $this->adminTitle = t('create_post');
	    }
	    elseif ($id > 0) {
	        $model = AdminPost::model()->findByPk($id);
	        $this->adminTitle = t('edit_post');
	    }
	    else
	        throw new CHttpException(500);
	    
	    if (request()->getIsPostRequest() && isset($_POST['AdminPost'])) {
	        $model->attributes = $_POST['AdminPost'];
	        // 此处如果以后有多种文章模型了，这一句可以去掉。
	        if ($model->getIsNewRecord())
    	        $model->post_type = AdminPost::TYPE_POST;
	        if ($model->save()) {
	            $this->afterPostSave($model);
	            user()->setFlash('save_post_result', t('save_post_success', 'admin', array('{title}'=>$model->title, '{url}'=>$model->url)));
                $this->redirect(request()->getUrl());
	        }
	    }
	    else {
	        $key = param('sess_post_create_token');
            if (!app()->session->contains($key) || empty(app()->session[$key])) {
                $token = $model->getIsNewRecord() ? uniqid('beta', true) : $model->id;
                app()->session->add($key, $token);
    	    }
            else {
                $token = app()->session[$key];
                $tempPictures = Upload::model()->findAllByAttributes(array('token'=>$token));
            }
	    }
	    
		$this->render('create', array(
		    'model'=>$model,
	        'tempPictures' => $tempPictures,
		));
	}
	
	private function afterPostSave(AdminPost $post)
	{
	    $key = param('sess_post_create_token');
        if (app()->session->contains($key) && $token = app()->session[$key] && !is_numeric($token)) {
            if (!$post->hasErrors()) {
                $attributes = array('post_id'=>$post->id, 'token'=>'');
                AdminUpload::model()->updateAll($attributes, 'token = :token', array(':token'=>$token));
                app()->session->remove($key);
            }
        }
	}
	
	public function actionLatest($cid = 0, $tid = 0)
	{
	    $cid = (int)$cid;
	    $tid = (int)$tid;
	    $criteria = new CDbCriteria();
	    
	    $title = t('post_list_table', 'admin');
	    if ($cid > 0) {
	        $category = AdminCategory::model()->findByPk($cid);
	        if ($category === null)
	            throw new CException(t('category_is_not_exist', 'admin'));
	        
	        $title = $title . ' - ' . $category->postsLink;
	        $criteria->addColumnCondition(array('category_id'=>$cid));
	    }
	    
	    if ($tid > 0) {
	        $topic = AdminTopic::model()->findByPk($tid);
	        if ($topic === null)
	            throw new CException(t('topic_is_not_exist', 'admin'));
	         
	        $title = $title . ' - ' . $topic->postsLink;
	        $criteria->addColumnCondition(array('topic_id'=>$tid));
	    }
	    
	    $data = AdminPost::fetchList($criteria);
	    
	    $this->adminTitle = $title;
	    $this->render('list', $data);
	}
	
	public function actionVerify()
	{
	    $criteria = new CDbCriteria();
	    $criteria->addColumnCondition(array('t.state'=>AdminPost::STATE_DISABLED));
	    $data = AdminPost::fetchList($criteria);
	    
	    $this->adminTitle = t('noverify_post_list_table', 'admin');
	    $this->render('list', $data);
	}
	
	public function actionSearch()
	{
	    $form = new PostSearchForm();
	    
	    if (isset($_GET['PostSearchForm'])) {
	        $form->attributes = $_GET['PostSearchForm'];
	        if ($form->validate())
	            $data = $form->search();
	        user()->setFlash('table_caption', t('post_search_result', 'admin'));
	    }
	    
        $this->render('search', array('form'=>$form, 'data'=>$data));
	}
	
	public function actionHottest()
	{
	    $criteria = new CDbCriteria();
	    $criteria->addColumnCondition(array('hottest'=>BETA_YES));
	    $data = AdminPost::fetchList($criteria);
	     
	    $this->render('list', $data);
	}
	
	public function actionRecommend()
	{
	    $criteria = new CDbCriteria();
	    $criteria->addColumnCondition(array('recommend'=>BETA_YES));
	    $data = AdminPost::fetchList($criteria);
	     
	    $this->render('list', $data);
	}
	
	public function actionHomeshow()
	{
	    $criteria = new CDbCriteria();
	    $criteria->addColumnCondition(array('homeshow'=>BETA_YES));
	    $data = AdminPost::fetchList($criteria);
	     
	    $this->render('list', $data);
	}
	
	public function actionIstop()
	{
	    $criteria = new CDbCriteria();
	    $criteria->addColumnCondition(array('istop'=>BETA_YES));
	    $data = AdminPost::fetchList($criteria);
	     
	    $this->render('list', $data);
	}
	
	// @todo 回收站，暂时不用
	public function actionTrash()
	{
	    $criteria = new CDbCriteria();
	    $criteria->addColumnCondition(array('state'=>AdminPost::STATE_TRASH));
	    $data = AdminPost::fetchList($criteria);
	     
	    $this->render('list', $data);
	}
	
	public function actionQuickUpdate($id, $callback)
	{
	    $id = (int)$id;
	    
	    if ($id <= 0)
	        throw new CHttpException(500, t('invalid_request', 'admin'));

	    $model = AdminPost::model()->findByPk($id);
	    if ($model === null)
	        throw new CHttpException(404, t('post_is_not_exist', 'admin'));
	     
        $model->attributes = $_POST['AdminPost'];
        if ($model->getIsNewRecord())
	        $model->post_type = AdminPost::TYPE_POST;
        
        $attributes = array('state', 'hottest', 'recommend', 'istop', 'homeshow', 'disable_comment');
        $result = (int)$model->save(true, $attributes);
        
        BetaBase::jsonp($callback, $result);
	}
	
	
	

    public function actionSetVerify($id, $callback)
	{
	    $id = (int)$id;
	    $model = AdminPost::model()->findByPk($id);
	    if ($model === null)
	        throw new CHttpException(500);
	    
	    $model->state = abs($model->state - AdminPost::STATE_ENABLED);
	    if ($model->state == AdminPost::STATE_ENABLED) {
	        $model->create_time = $_SERVER['REQUEST_TIME'];
	        $attributes = array('state', 'create_time');
	    }
	    else
	        $attributes = array('state');
	    
        $model->save(true, $attributes);
	    if ($model->hasErrors())
	        throw new CHttpException(500);
	    else {
	        $data = array(
	            'errno' => BETA_NO,
	            'label' => t($model->state == AdminPost::STATE_ENABLED ? 'sethide' : 'setshow', 'admin')
	        );
	        BetaBase::jsonp($callback, $data);
	    }
	}

	public function actionSetDelete($id, $callback)
	{
	    $id = (int)$id;
	    $model = AdminPost::model()->findByPk($id);
	    if ($model === null)
	        throw new CHttpException(500);
	     
	    if ($model->delete()) {
	        $data = array(
	            'errno' => BETA_NO,
	            'label' => t('delete_success', 'admin'),
	        );
	        BetaBase::jsonp($callback, $data);
	    }
	    else
	        throw new CHttpException(500);
	}

	public function actionSetTrash($id, $callback)
	{
	    $id = (int)$id;
	    $model = AdminPost::model()->findByPk($id);
	    if ($model === null)
	        throw new CHttpException(404);
	     
	    if ($model->trash()) {
	        $data = array(
	            'errno' => BETA_NO,
	            'label' => t('delete_success', 'admin'),
	        );
	        BetaBase::jsonp($callback, $data);
	    }
	    else
	        throw new CHttpException(500);
	}

	/**
	 * 批量删除文章
	 * @param array $ids ID数组
	 * @param string $callback jsonp回调函数，自动赋值
	 */
	public function actionMultiDelete($callback)
	{
	    $ids = (array)request()->getPost('ids');
	    $successIds = $failedIds = array();
	    foreach ($ids as $id) {
	        $model = AdminPost::model()->findByPk($id);
	        if ($model === null)
	            continue;
	        	
	        $result = $model->delete();
	        if ($result)
	            $successIds[] = $id;
	        else
	            $failedIds[] = $id;
	    }
	    $data = array(
    	    'success' => $successIds,
    	    'failed' => $failedIds,
	    );
	    BetaBase::jsonp($callback, $data);
	}
	
	/**
	 * 批量将文章扔到回收站
	 * @param array $ids ID数组
	 * @param string $callback jsonp回调函数，自动赋值
	 */
	public function actionMultiTrash($callback)
	{
	    $ids = (array)request()->getPost('ids');
	    $successIds = $failedIds = array();
	    foreach ($ids as $id) {
	        $model = AdminPost::model()->findByPk($id);
	        if ($model === null)
	            continue;
	        	
	        $result = $model->trash();
	        if ($result)
	            $successIds[] = $id;
	        else
	            $failedIds[] = $id;
	    }
	    $data = array(
    	    'success' => $successIds,
    	    'failed' => $failedIds,
	    );
	    BetaBase::jsonp($callback, $data);
	}
	

	/**
	 * 批量审核文章
	 * @param array $ids 文章ID数组
	 * @param string $callback jsonp回调函数，自动赋值
	 */
	public function actionMultiVerify($callback)
	{
	    $ids = (array)request()->getPost('ids');
	     
	    $successIds = $failedIds = array();
	    $attributes = array(
	        'state' => AdminPost::STATE_ENABLED,
	        'create_time' => $_SERVER['REQUEST_TIME'],
	    );
	    foreach ($ids as $id) {
	        $result = AdminPost::model()->updateByPk($id, $attributes);
	        if ($result)
	            $successIds[] = $id;
	        else
	            $failedIds[] = $id;
	    }
	    $data = array(
    	    'success' => $successIds,
    	    'failed' => $failedIds,
	    );
	    BetaBase::jsonp($callback, $data);
	}

	/**
	 * 批量拒绝文章
	 * @param array $ids 文章ID数组
	 * @param string $callback jsonp回调函数，自动赋值
	 */
	public function actionMultiReject($callback)
	{
	    $ids = (array)request()->getPost('ids');
	     
	    $successIds = $failedIds = array();
	    $attributes = array(
	        'state' => AdminPost::STATE_REJECTED,
	    );
	    foreach ($ids as $id) {
	        $result = AdminPost::model()->updateByPk($id, $attributes);
	        if ($result)
	            $successIds[] = $id;
	        else
	            $failedIds[] = $id;
	    }
	    $data = array(
    	    'success' => $successIds,
    	    'failed' => $failedIds,
	    );
	    BetaBase::jsonp($callback, $data);
	}
	
	/**
	 * 批量推荐文章
	 * @param array $ids 文章ID数组
	 * @param string $callback jsonp回调函数，自动赋值
	 */
	public function actionMultiRecommend($callback)
	{
	    $ids = (array)request()->getPost('ids');
	     
	    $successIds = $failedIds = array();
	    $attributes = array(
    	    'state' => AdminPost::STATE_ENABLED,
    	    'recommend' => BETA_YES,
    	    'create_time' => $_SERVER['REQUEST_TIME'],
	    );
	    foreach ($ids as $id) {
	        $result = AdminPost::model()->updateByPk($id, $attributes);
	        if ($result)
	            $successIds[] = $id;
	        else
	            $failedIds[] = $id;
	    }
	    $data = array(
    	    'success' => $successIds,
    	    'failed' => $failedIds,
	    );
	    BetaBase::jsonp($callback, $data);
	}
	
	/**
	 * 批量设置热门文章
	 * @param array $ids 文章ID数组
	 * @param string $callback jsonp回调函数，自动赋值
	 */
	public function actionMultiHottest($callback)
	{
	    $ids = (array)request()->getPost('ids');
	     
	    $successIds = $failedIds = array();
	    foreach ($ids as $id) {
	        $model = AdminPost::model()->findByPk($id);
	        if ($model === null) continue;
	         
	        $model->hottest = BETA_YES;
	        $model->state = AdminPost::STATE_ENABLED;
	         
	        $result = $model->save(true, array('hottest', 'state'));
	        if ($result)
	            $successIds[] = $id;
	        else
	            $failedIds[] = $id;
	    }
	    $data = array(
    	    'success' => $successIds,
    	    'failed' => $failedIds,
	    );
	    BetaBase::jsonp($callback, $data);
	}

	
}