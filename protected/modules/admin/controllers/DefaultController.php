<?php

class DefaultController extends AdminController
{
	public function actionIndex()
	{
		$this->renderPartial('index');
	}
	
	public function actionWelcome()
	{
	    $criteria = new CDbCriteria();
	    $criteria->addColumnCondition(array('state'=>AdminPost::STATE_DISABLED));
	    $unVerifyCount = AdminPost::model()->count($criteria);
	    
	    $this->render('welcome', array(
	        'unVerifyCount' => $unVerifyCount,
	    ));
	}

    public function actionTest()
    {
        $this->layout = 'test';
        $this->render('welcome');
    }
}