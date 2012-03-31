<?php

class DefaultController extends AdminController
{
	public function actionIndex()
	{
		$this->renderPartial('index');
	}
	
	public function actionWelcome()
	{
	    $this->render('welcome');
	}

    public function actionTest()
    {
        $this->layout = 'test';
        $this->render('welcome');
    }
}