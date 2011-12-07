<?php

return array(
    //'id'
    'name' => 'wabao.me',
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'layout' => 'main',

    'import' => array(
		'application.models.*',
		'application.components.*',
        'application.extensions.*',
        'application.helpers.*',
        'application.libs.*',
	),
	
    'components' => array(
        'urlManager' => array(
            'urlFormat' => 'get',
            'rules' => array(
                
            ),
        ),
        
        'fcache' => array(
		    'class' => 'CdcFileCache',
		    'directoryLevel' => 2,
		),
    ),

    'params' => array(
        
    ),
);