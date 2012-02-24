<?php

class CategoryController extends Controller
{
    public function init()
    {
        $this->layout = 'category';
    }
    
	public function actionIndex()
	{
		$this->render('index');
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
	     
	    $parents = AdminCategory::fetchRootList();
	    $parents = CHtml::listData($parents, 'id', 'name');
	    $empty = array(AdminCategory::ROOT_PARENT_ID => t('please_select_category', 'admin'));
	    $this->render('create', array(
    	    'model' => $model,
    	    'parents' => (array)$parents,
    	    'empty' => $empty,
	    ));
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
	
	public function actionHottest($count)
	{
	     
	}
}