<?php

class DefaultController extends Controller
{
	public function actionIndex()
	{
		$this->renderPartial('index');
	}
	
	public function actionSidebar()
	{
	    $menus = require(dirname(__FILE__) . DS . '..' . DS . 'config' . DS . 'sidebar_menu.php');
	    
	    $this->render('sidebar', array('menus'=>$menus));
	}
	
	public function actionWelcome()
	{
	    $this->render('welcome');
	}
	
	public function actionShortcut()
	{
	    echo __FILE__;
	}
}