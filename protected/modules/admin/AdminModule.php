<?php

class AdminModule extends CWebModule
{
	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'admin.models.*',
			'admin.components.*',
		));
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
		    // @todo 此处会有登录次数限制条件处理，比如一分钟内只允许访问几次，如果超过直接抛出500错误
			if (user()->getIsGuest()) {
			    $url = url('site/login', array('url'=>request()->getUrl()));
    			request()->redirect($url);
    			exit(0);
			}
			elseif (user()->checkAccess('enterAdminSystem'))
    			return true;
			else {
			    echo 'you are not allowed enter admin system.';
			    exit(0);
			}
		}
		else
			return false;
	}
}
