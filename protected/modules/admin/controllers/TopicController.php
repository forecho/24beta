<?php

class TopicController extends AdminController
{
    public function filters()
    {
        return array(
            'postOnly + updateOrderID',
        );
    }
    

	public function actionCreate($id = 0)
	{
	    $id = (int)$id;
	    
	    if ($id > 0) {
	        $model = AdminTopic::model()->findByPk($id);
	        $this->adminTitle = t('edit_topic', 'admin');
	    }
	    else {
	        $model = new AdminTopic();
	        $this->adminTitle = t('create_topic', 'admin');
	    }
	    
	    if (request()->getIsPostRequest() && isset($_POST['AdminTopic'])) {
	        $model->attributes = $_POST['AdminTopic'];
	        $model->icon = CUploadedFile::getInstance($model, 'icon');
	        
	        $attributes = $model->attributes;
	        if (!($model->icon instanceof CUploadedFile))
	            unset($attributes['icon']);
	        $attributes = array_keys($attributes);
	        if ($model->save(true, $attributes) && $model->saveIcon() !== false) {
	            user()->setFlash('save_topic_result', t('save_topic_success', 'admin', array('{name}'=>$model->name)));
	            $this->redirect(request()->getUrl());
	        }
	    }
	    
	    $this->render('create', array(
	        'model' => $model,
	    ));
	}
	

	public function actionUpdateOrderID()
	{
	    try {
	        $rows = (array)$_POST['itemid'];
	        foreach ($rows as $id => $orderid) {
	            AdminTopic::model()->updateByPk((int)$id, array('orderid'=>(int)$orderid));
	        }
	        user()->setFlash('order_id_save_result_success', t('order_id_save_success', 'admin'));
	    }
	    catch (Exception $e) {
	        user()->setFlash('order_id_save_result_error', t('order_id_save_error', 'admin', array('{error}'=>$e->getMessage())));
	    }
	    request()->redirect(url('admin/topic/list'));
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
	
	public function actionStatistics()
	{
	    $criteria = new CDbCriteria();
	    $criteria->limit = param('adminTopicCountOfPage');
	    
	    $sort = new CSort('Topic');
	    $sort->defaultOrder = 'post_nums desc, id asc';
	    $sort->applyOrder($criteria);
	    
	    $pages = new CPagination(Topic::model()->count($criteria));
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