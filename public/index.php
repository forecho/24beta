<?php
defined('YII_DEBUG') or define('YII_DEBUG', true);
!defined('YII_DEBUG') && error_reporting(0);
defined('DS') or define('DS', DIRECTORY_SEPARATOR);

$yii = dirname(__FILE__) . '/../library/framework/yii.php';
$config = dirname(__FILE__) . '/../protected/config/main.php';
$shortcut = dirname(__FILE__) . '/../library/shortcut.php';

require_once($yii);
require_once($shortcut);

$app = Yii::createWebApplication($config);
$app->run();
