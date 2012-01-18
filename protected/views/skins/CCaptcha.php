<?php
return array(
    'default' => array(
	    'captchaAction' => 'captcha',
    	'buttonLabel' => t('refresh_captcha'),
    	'clickableImage' => true,
        'imageOptions' => array('alt'=>t('captcha'), 'align'=>'top'),
        'buttonOptions' => array('class'=>'refresh-captcha'),
    ),
    'big' => array(
	    'captchaAction' => 'bigcaptcha',
    	'buttonLabel' => t('refresh_captcha'),
    	'clickableImage' => true,
        'imageOptions' => array('alt'=>t('captcha'), 'align'=>'top'),
        'buttonOptions' => array('class'=>'refresh-captcha'),
    ),
);