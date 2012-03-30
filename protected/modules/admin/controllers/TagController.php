<?php

class TagController extends AdminController
{
    public function init()
    {
        $this->layout = 'tag';
    }
    
	public function actionIndex()
	{
		$this->render('index');
	}
    
	public function actionSearch($keyword = '', $fuzzy = 0)
	{
	    $keyword = trim($keyword);
	    if ($keyword) {
	        $criteria = new CDbCriteria();
	        if ($fuzzy)
	            $criteria->addSearchCondition('name', $keyword);
            else
    	        $criteria->addColumnCondition(array('name'=>$keyword));
	        $criteria->order = 'post_nums desc, id asc';
	        $criteria->limit = param('adminTagCountOfPage');
	        
	        $pages = new CPagination(Tag::model()->count($criteria));
	        $pages->setPageSize(param('adminTagCountOfPage'));
	        $pages->applyLimit($criteria);

	        $tags = Tag::model()->findAll($criteria);
	    
	        $this->render('search', array(
	            'tags' => $tags,
	            'pages' => null,
	        ));
	    }
	    else
    	    $this->render('search');
	}
	
	public function actionHottest($count = 20)
	{
	    $criteria = new CDbCriteria();
	    $criteria->limit = (int)$count;
	    $criteria->order = 'post_nums desc, id asc';
	    $tags = Tag::model()->findAll($criteria);
	    user()->setFlash('table_caption', t('hottest_tags_list', 'admin') . '：Top ' . $count);
	    
	    $this->render('list', array('models'=>$tags, 'pages'=>null));
	}
	
	public function actionLatest($count = 20)
	{
	    $criteria = new CDbCriteria();
	    $criteria->limit = (int)$count;
	    $criteria->order = 'id desc';
	    $tags = Tag::model()->findAll($criteria);
	    user()->setFlash('table_caption', t('latest_tags_list', 'admin') . '：Top ' . $count);
	     
	    $this->render('list', array('models'=>$tags, 'pages'=>null));
	}
}