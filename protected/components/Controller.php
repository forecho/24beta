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
				'class'=>'application.extensions.BetaCaptchaAction.BetaCaptchaAction',
				'backColor' => 0xFFFFFF,
				'height' => 22,
				'width' => 70,
				'maxLength' => 4,
				'minLength' => 4,
		        'foreColor' => 0xFF0000,
		        'padding' => 3,
		        'testLimit' => 1,
// 			    'fixedVerifyCode' => '1231',
			),
		);
	}
	
	public $breadcrumbs = array();
	
	protected function setPageKeyWords($value)
	{
	    if (empty($value)) return false;
	    
	    $value = (array)$value;
	    array_push($value, param('sitename'));
	    $text = strip_tags(trim(join(',', $value)));
	    cs()->registerMetaTag($text, 'keywords');
	}
	
    protected function setPageDescription($value)
	{
	    if (empty($value)) return false;
	    
	    $value = (array)$value;
	    $sitename = param('sitename');
	    if (param('shortdesc'))
	        $sitename = $sitename . ' - ' . param('shortdesc');
	    array_push($value, $sitename);
	    $text = strip_tags(trim(join(',', $value)));
	    cs()->registerMetaTag($text, 'description');
	}

	public function setSiteTitle($value)
	{
        $titleArray = array(param('sitename'));
        if (param('shortdesc'))
            array_push($titleArray, param('shortdesc'));
        if (!empty($value))
    	    array_unshift($titleArray, $value);

        $text = strip_tags(trim(join(' - ', $titleArray)));
	    $this->pageTitle = $text;
	}

}