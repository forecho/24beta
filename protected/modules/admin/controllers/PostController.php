<?php

class PostController extends Controller
{
	public function actionCreate($id = 0)
	{
		$this->render('create');
	}
	
	public function actionToday()
	{
	    $this->render('list');
	}
	
	public function actionList()
	{
	    $this->render('list');
	}
	
	public function actionVerify()
	{
	    $criteria = new CDbCriteria();
	    $criteria->addColumnCondition(array('state'=>Post::STATE_DISABLED));
	    $data = self::fetchList($criteria);
	    
	    $this->render('list', $data);
	}
	
	public function actionSearch()
	{
	    $this->render('search');
	}
	
	private static function fetchList($criteria = null, $sort = true, $pages = true)
	{
	    $criteria = ($criteria === null) ? new CDbCriteria() : $criteria;
	    $criteria->limit = param('adminPostCountOfPage');
	    $criteria->order = 'id desc';
	    
	    if ($sort) {
	        $sort  = new CSort('Post');
	        $sort->defaultOrder = 'id desc';
	        $sort->applyOrder($criteria);
	    }
	    
	    if ($pages) {
	        $count = Post::model()->count($criteria);
	        $pages = new CPagination($count);
	    }
	    
	    $models = Post::model()->findAll($criteria);
	    
	    $data = array(
            'models' => $models,
            'sort' => $sort,
	        'pages' => $pages,
        );
	    
	    return $data;
	}

}