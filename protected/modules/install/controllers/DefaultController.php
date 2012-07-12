<?php

class DefaultController extends InstallController
{
	public function actionIndex()
	{
	    $this->step = 0;
	    $this->pageTitle = '24Blog 安装向导';
		$this->render('index');
	}
	
	public function actionStep1()
	{
	    $this->step = 1;
	    $this->pageTitle = '第一步：检测系统环境';
	    $this->render('step1');
	}
	
	public function actionStep2()
	{
	    $this->step = 2;
	    $this->pageTitle = '第二步：填写网站基本信息';
	    $this->render('step2');
	}
	
	public function actionStep3()
	{
	    $this->step = 3;
	    $this->pageTitle = '第三步：安装完成';
	    $this->render('step3');
	}
}