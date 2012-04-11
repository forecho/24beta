<?php

class PostController extends AdminController
{
    public function filters()
    {
        return array(
            'ajaxOnly + setVerify, setHottest, setRecommend, setDelete, multiDelete',
            'postOnly + setVerify, setHottest, setRecommend, setDelete, multiDelete',
        );
    }
    
	public function actionCreatePost($id = 0)
	{
	    $id = (int)$id;
	    if ($id === 0) {
	        $model = new AdminPost();
	        $this->adminTitle = t('create_post');
	    }
	    else {
	        $model = AdminPost::model()->findByPk($id);
	        $this->adminTitle = t('edit_post');
	    }
	    
	    if (request()->getIsPostRequest() && isset($_POST['AdminPost'])) {
	        $model->attributes = $_POST['AdminPost'];
	        $model->post_type = AdminPost::TYPE_POST;
	        if ($model->save()) {
	            user()->setFlash('save_post_result', t('save_post_success', 'admin', array('{title}'=>$model->title, '{url}'=>$model->url)));
	            $this->redirect(request()->getUrl());
	        }
	    }
	    
	    $this->layout = 'main';
		$this->render('create', array('model'=>$model));
	}
	
	public function actionLatest()
	{
	    $count = (int)$count;
	    $criteria = new CDbCriteria();
	    $data = AdminPost::fetchList($criteria);
	    
	    $this->render('list', $data);
	}
	
	public function actionVerify()
	{
	    $criteria = new CDbCriteria();
	    $criteria->addColumnCondition(array('state'=>AdminPost::STATE_DISABLED));
	    $data = AdminPost::fetchList($criteria);
	    
	    $this->render('list_noverify', $data);
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
	        echo $callback . '(' . CJSON::encode($data) . ')';
	        exit(0);
	    }
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
	
	public function actionDeleted()
	{
	    $criteria = new CDbCriteria();
	    $criteria->addColumnCondition(array('state'=>AdminPost::STATE_DELETED));
	    $data = AdminPost::fetchList($criteria);
	     
	    $this->render('list', $data);
	}
	
	public function actionSetHottest($id, $callback)
	{
	    $id = (int)$id;
	    $model = AdminPost::model()->findByPk($id);
	    if ($model === null)
	        throw new CHttpException(500);
	     
	    $model->hottest = abs($model->hottest - BETA_YES);
	    $model->save(true, array('hottest'));
	    if ($model->hasErrors())
	        throw new CHttpException(500);
	    else {
	        $data = array(
	            'errno' => BETA_NO,
	            'label' => t($model->hottest == BETA_YES ? 'cancel_hottest_post' : 'set_hottest_post', 'admin')
	        );
	        echo $callback . '(' . CJSON::encode($data) . ')';
	        exit(0);
	    }
	}

	public function actionSetRecommend($id, $callback)
	{
	    $id = (int)$id;
	    $model = AdminPost::model()->findByPk($id);
	    if ($model === null)
	        throw new CHttpException(500);
	     
	    $model->recommend = abs($model->recommend - BETA_YES);
	    $model->save(true, array('recommend'));
	    if ($model->hasErrors())
	        throw new CHttpException(500);
	    else {
	        $data = array(
	            'errno' => BETA_NO,
	            'label' => t($model->recommend == BETA_YES ? 'cancel_recommend_post' : 'set_recommend_post', 'admin')
	        );
	        echo $callback . '(' . CJSON::encode($data) . ')';
	        exit(0);
	    }
	}

	public function actionSetHomeshow($id, $callback)
	{
	    $id = (int)$id;
	    $model = AdminPost::model()->findByPk($id);
	    if ($model === null)
	        throw new CHttpException(500);
	     
	    $model->homeshow = abs($model->homeshow - BETA_YES);
	    $model->save(true, array('homeshow'));
	    if ($model->hasErrors())
	        throw new CHttpException(500);
	    else {
	        $data = array(
	            'errno' => BETA_NO,
	            'label' => t($model->homeshow == BETA_YES ? 'cannel_homeshow_post' : 'set_homeshow_post', 'admin')
	        );
	        echo $callback . '(' . CJSON::encode($data) . ')';
	        exit(0);
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
	        echo $callback . '(' . CJSON::encode($data) . ')';
	        exit(0);
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
	    echo $callback . '(' . CJSON::encode($data) . ')';
	    exit(0);
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
	    echo $callback . '(' . CJSON::encode($data) . ')';
	    exit(0);
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
	    echo $callback . '(' . CJSON::encode($data) . ')';
	    exit(0);
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
	    echo $callback . '(' . CJSON::encode($data) . ')';
	    exit(0);
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
	    echo $callback . '(' . CJSON::encode($data) . ')';
	    exit(0);
	}
}