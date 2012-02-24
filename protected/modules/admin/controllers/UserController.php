<?php

class UserController extends Controller
{
    public function init()
    {
        $this->layout = 'user';
    }
    
	public function actionIndex()
	{
		$this->render('index');
	}
	
	public function actionVerify()
	{
	    $this->render('list', $data);
	}
	
	public function actionMostActive()
	{
	    $this->render('list', $data);
	}
	
	public function actionCreate()
	{
	    $this->render('create', array('model'=>$model));
	}
	
	public function actionEdit($id)
	{
	    $this->render('edit', array('model'=>$model));
	}
	
	public function actionSearch()
	{
	    $this->render('search', array(
            'form' => $form,
        ));
	}
}