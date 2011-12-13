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
	    $this->render('list');
	}
	
	public function actionSearch()
	{
	    $this->render('search');
	}

}