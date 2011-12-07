<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
	public function actions()
	{
		return array(
			'captcha'=>array(
				'class'=>'application.extensions.CdCaptcha.CdCaptchaAction',
				'backColor' => 0xFFFFFF,
				'height' => 22,
				'width' => 70,
				'maxLength' => 4,
				'minLength' => 4,
		        'foreColor' => 0xFF0000,
		        'padding' => 3,
		        'testLimit' => 1,
			),
		);
	}
	
	public $breadcrumbs = array();
	
	protected function setPageKeyWords($text)
	{
	    if (empty($text)) return false;
	    
	    if (is_array($text)) $text = join(',', $text);
	    cs()->registerMetaTag($text . ',' . param('shortdesc'), 'keywords');
	}
	
    protected function setPageDescription($text)
	{
	    if (empty($text)) return false;
	    
	    if (is_array($text)) $text = join(',', $text);
	    cs()->registerMetaTag($text . '，' . param('shortdesc') . '，' . param('description'), 'description');
	}


}