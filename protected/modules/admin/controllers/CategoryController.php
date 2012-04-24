<?php

class CategoryController extends AdminController
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
	    
	    if ($id === 0) {
    	    $model = new AdminCategory();
    	    $this->adminTitle = t('create_category', 'admin');
	    }
	    else {
	        $model = AdminCategory::model()->findByPk($id);
	        $this->adminTitle = t('edit_category', 'admin');
	    }
	     
	    if (request()->getIsPostRequest() && isset($_POST['AdminCategory'])) {
	        $model->attributes = $_POST['AdminCategory'];
	        if ($model->save()) {
	            user()->setFlash('save_category_result', t('save_category_success', 'admin', array('{name}'=>$model->name)));
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
    	        AdminCategory::model()->updateByPk((int)$id, array('orderid'=>(int)$orderid));
    	    }
    	    user()->setFlash('order_id_save_result_success', t('order_id_save_success', 'admin'));
	    }
	    catch (Exception $e) {
	        user()->setFlash('order_id_save_result_error', t('order_id_save_error', 'admin', array('{error}'=>$e->getMessage())));
	    }
	    request()->redirect(url('admin/category/list'));
	}
	
	public function actionList()
	{
	    $criteria = new CDbCriteria();
	    $criteria->limit = param('adminCategoryCountOfPage');
	     
	    $sort = new CSort('Category');
	    $sort->defaultOrder = 'orderid desc, id asc';
	    $sort->applyOrder($criteria);
	     
	    $pages = new CPagination(AdminCategory::model()->count($criteria));
	    $pages->pageSize = $criteria->limit;
	    $pages->applyLimit($criteria);
	     
	    $models = AdminCategory::model()->findAll($criteria);
	     
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
	    $criteria->limit = param('adminCategoryCountOfPage');
	    
	    $sort = new CSort('Category');
	    $sort->defaultOrder = 'post_nums desc, id asc';
	    $sort->applyOrder($criteria);
	    
	    $pages = new CPagination(AdminCategory::model()->count($criteria));
	    $pages->pageSize = param('adminCategoryCountOfPage');
	    $pages->applyLimit($criteria);
	    
	    $models = AdminCategory::model()->findAll($criteria);
	    
	    $data = array(
            'models' => $models,
            'sort' => $sort,
            'pages' => $pages,
	    );
	    
	    $this->render('list', $data);
	}
}