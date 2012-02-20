<?php
define('BETA_CONFIG_ROOT', dirname(__FILE__));
defined('DS') or define('DS', DIRECTORY_SEPARATOR);
define('BETA_YES', 1);
define('BETA_NO', 0);

$params = require(BETA_CONFIG_ROOT . DS . 'params.php');
$setting = require(BETA_CONFIG_ROOT . DS . 'setting.php');
$params = array_merge($setting, $params);
return array(
    'id' => $params['domain'],
    'name' => $params['sitename'],
    'basePath' => BETA_CONFIG_ROOT . DS . '..',
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
            'returnUrl' => array('site/index')
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
            'basePath' => BETA_CONFIG_ROOT . DS . '..' . DS . '..' . DS . 'themes',
            'baseUrl' => $params['themeResourceBaseUrl'],
        ),
        'urlManager' => array(
            'urlFormat' => 'path',
		    'showScriptName' => false,
            'cacheID' => 'fcache',
            'rules' => array(
                'page/<page:\d+>' => 'site/index',
                '' => 'site/index',
                '<id:\d+>' => 'post/show',
                '<_a:(login|signup|logout)>' => 'site/<_a>',
                '<_c:(category|topic)>-<id:\d+>-page-<page:\d+>' => '<_c>/posts',
                '<_c:(category|topic)>-<id:\d+>' => '<_c>/posts',
            ),
        ),
        'session' => array(
            'cookieParams' => array(
                'lifetime' => $params['autoLoginDuration'],
                'domain' => $params['domain'],
            ),
        ),
        'widgetFactory'=>array(
            'enableSkin'=>true,
        ),
    ),

    'params' => $params,
);