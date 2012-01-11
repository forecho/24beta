<?php
defined('DS') or define('DS', DIRECTORY_SEPARATOR);

$params = require(dirname(__FILE__) . DS . 'params.php');
$setting = require(dirname(__FILE__) . DS . 'setting.php');
$params = array_merge($setting, $params);
return array(
    'id' => $params['domain'],
    'name' => $params['sitename'],
    'basePath' => dirname(__FILE__) . DS . '..',
    'charset' => 'utf-8',
    'language' => $params['language'],
    'layout' => 'main',
    'timezone' => $params['timezone'],
    'theme' => $params['theme'],

    'import' => array(
		'application.models.*',
		'application.components.*',
        'application.extensions.*',
        'application.helpers.*',
        'application.libs.*',
        'application.widgets.*',
	),
        
    'modules' => array(
        'admin' => array(
            'layout' => 'main',
        ),
    ),
    'preload' => array('log'),
    'components' => array(
        'log' => array(
            'class'=>'CLogRouter',
            'routes'=>array(
                array(
                    'class'=>'CFileLogRoute',
                    'categories'=>'system.db.*',
                ),
                /* array(
                    'class'=>'CWebLogRoute',
                    'levels'=>'trace,info,error,notic',
                    'categories'=>'system.db.*',
                ), */
            ),
        ),
        'user' => array(
            'allowAutoLogin' => true,
            'loginUrl' => array('site/login'),
        ),
        'db' => array(
            'class' => 'CDbConnection',
			'connectionString' => 'mysql:host=127.0.0.1; port=3306; dbname=cd_24beta',
			'username' => 'root',
		    'password' => '123',
		    'charset' => 'utf8',
		    'persistent' => true,
		    'tablePrefix' => 'cd_',
            'enableParamLogging' => true,
            'enableProfiling' => true,
// 		    'schemaCacheID' => 'fcache',
// 		    'schemaCachingDuration' => 3600 * 24,    // metadata 缓存超时时间(s)
// 		    'queryCacheID' => 'cache',
// 		    'queryCachingDuration' => 60,
        ),
        'cache' => array(
            'class' => 'CFileCache',
            'directoryLevel' => 2,
        ),
        'fcache' => array(
		    'class' => 'CFileCache',
		    'directoryLevel' => 2,
		),
        'assetManager' => array(
            'basePath' => $params['resourceBasePath'] . 'assets',
            'baseUrl' => $params['resourceBaseUrl'] . 'assets',
        ),
        'themeManager' => array(
            'basePath' => dirname(__FILE__) . DS . '..' . DS . '..' . DS . 'themes',
            'baseUrl' => $params['themeResourceBaseUrl'],
        ),
        'urlManager' => array(
            'urlFormat' => 'path',
		    'showScriptName' => false,
            'cacheID' => 'fcache',
            'rules' => array(
                
            ),
        ),
        'session' => array(
            'cookieParams' => array(
                'lifetime' => $params['autoLoginDuration'],
                'domain' => $params['domain'],
            ),
        ),
    ),

    'params' => $params,
);