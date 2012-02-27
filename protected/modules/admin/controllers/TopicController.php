<?php

class TopicController extends Controller
{
    public function init()
    {
        $this->layout = 'topic';
    }
    
	public function actionIndex()
	{
		$this->render('index');
	}

	public function actionCreate($id = 0)
	{
	    $id = (int)$id;
	    
	    $parents = AdminTopic::fetchRootList();
	    $parents = CHtml::listData($parents, 'id', 'name');
	    $empty = array(AdminTopic::ROOT_PARENT_ID => t('please_select_topic', 'admin'));
	    
	    if ($id === 0) {
	        $model = new AdminTopic();
	        $this->adminTitle = t('create_topic', 'admin');
	    }
	    else {
	        $model = AdminTopic::model()->findByPk($id);
	        $this->adminTitle = t('edit_topic', 'admin');
	        unset($parents[$id]);
	    }
	    
	    if (request()->getIsPostRequest() && isset($_POST['AdminTopic'])) {
	        $model->attributes = $_POST['AdminTopic'];
	        $model->icon = CUploadedFile::getInstance($model, 'icon');
	        if ($model->save() && $model->saveIcon() !== false) {
	            user()->setFlash('save_topic_result', t('save_topic_success', 'admin', array('{name}'=>$model->name)));
	            $this->redirect(request()->getUrl());
	        }
	    }
	    
	    $this->render('create', array(
	        'model' => $model,
	        'parents' => (array)$parents,
	        'empty' => $empty,
	    ));
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
	    $count = (int)$count;
	    $criteria = new CDbCriteria();
	    $criteria->limit = $count;
	    
	    $sort = new CSort('Topic');
	    $sort->defaultOrder = 'post_nums desc, id asc';
	    $sort->applyOrder($criteria);
	    
	    $pages = new CPagination($count);
	    $pages->pageSize = param('adminTopicCountOfPage');
	    $pages->applyLimit($criteria);
	    
	    $models = AdminTopic::model()->findAll($criteria);
	    
	    $data = array(
            'models' => $models,
            'sort' => $sort,
            'pages' => $pages,
	    );
	    
	    $this->render('list', $data);
	}
}