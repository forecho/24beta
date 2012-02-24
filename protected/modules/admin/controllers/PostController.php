<?php

class PostController extends Controller
{
	public function actionCreate($id = 0)
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
	        if ($model->save()) {
	            user()->setFlash('save_post_result', t('save_post_success', 'admin', array('{title}'=>$model->title, '{url}'=>$model->url)));
	            $this->redirect(request()->getUrl());
	        }
	    }
	    
		$this->render('create', array('model'=>$model));
	}
	
	public function actionToday()
	{
	    $time = $_SERVER['REQUEST_TIME'] - 24*60*60;
	    $criteria = new CDbCriteria();
	    $criteria->addCondition('create_time > ' . $time);
	    $data = AdminPost::fetchList($criteria);
	    
	    $this->render('list', $data);
	}
	
	public function actionList()
	{
	    $this->render('list');
	}
	
	public function actionVerify()
	{
	    $criteria = new CDbCriteria();
	    $criteria->addColumnCondition(array('state'=>AdminPost::STATE_DISABLED));
	    $data = AdminPost::fetchList($criteria);
	    
	    $this->render('list', $data);
	}
	
	public function actionSearch()
	{
	    $form = new PostSearchForm();
	    
	    if (isset($_GET['PostSearchForm'])) {
	        $form->attributes = $_GET['PostSearchForm'];
	        if ($form->validate())
	            $data = $form->search();
	        user()->setFlash('table_caption', '文章查询结果');
	    }
	    
        $this->render('search', array('form'=>$form, 'data'=>$data));
	}
	
	

}