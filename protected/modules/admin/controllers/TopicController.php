<?php

class TopicController extends Controller
{
	public function actionIndex()
	{
		$this->render('index');
	}

	public function actionCreate()
	{
	    
	}
	
	public function actionList()
	{
	    $criteria = new CDbCriteria();
	    $criteria->limit = param('adminTopicCountOfPage');
	    
	    $sort = new CSort('Topic');
	    $sort->defaultOrder = 'orderid desc, id asc';
	    $sort->applyOrder($criteria);
	    
	    $pages = new CPagination(AdminTopic::model()->count($criteria));
	    $pages->pageSize = $criteria->limit;
	    $pages->applyLimit($criteria);
	    
	    $models = AdminTopic::model()->findAll($criteria);
	    
	    $data = array(
	        'models' => $models,
	        'sort' => $sort,
	        'pages' => $pages,
	    );
	    
	    $this->render('list', $data);
	}
	
	public function actionHottest($count)
	{
	    
	}
}