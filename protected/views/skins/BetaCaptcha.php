<?php
return array(
    'default' => array(
	    'captchaAction' => 'captcha',
        'lazy' => false,
    	'buttonLabel' => t('refresh_captcha'),
    	'clickableImage' => true,
        'imageOptions' => array('alt'=>t('captcha'), 'align'=>'top'),
        'buttonOptions' => array('class'=>'refresh-captcha'),
    ),
    'defaultLazy' => array(
        'captchaAction' => 'captcha',
        'lazy' => true,
        'buttonLabel' => t('refresh_captcha'),
        'clickableImage' => true,
        'imageOptions' => array('alt'=>t('captcha'), 'align'=>'top', 'class'=>'beta-captcha-img'),
        'buttonOptions' => array('class'=>'refresh-captcha'),
    ),
    'big' => array(
	    'captchaAction' => 'bigcaptcha',
        'lazy' => false,
    	'buttonLabel' => t('refresh_captcha'),
    	'clickableImage' => true,
        'imageOptions' => array('alt'=>t('captcha'), 'align'=>'top'),
        'buttonOptions' => array('class'=>'refresh-captcha'),
    ),
);