<?php

class PostController extends Controller
{
	public function actionCreate($id = 0)
	{
	    $id = (int)$id;
	    if ($id === 0)
	        $model = new Post();
	    else
	        $model = Post::model()->findByPk($id);
	    
	    if (request()->getIsPostRequest() && isset($_POST['Post'])) {
	        $model->attributes = $_POST['Post'];
	        if ($model->save()) {
	            user()->setFlash('post_create_result', t('post_create_success', 'admin', array('{title}'=>$model->title, '{url}'=>$model->url)));
	            $this->redirect(url('admin/post/create'));
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
	    $criteria->addColumnCondition(array('state'=>Post::STATE_DISABLED));
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