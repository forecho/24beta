<?php
defined('YII_PRODUCT') or define('YII_PRODUCT', false);
defined('YII_DEBUG') or define('YII_DEBUG', true);
!defined('YII_DEBUG') && error_reporting(0);
defined('DS') or define('DS', DIRECTORY_SEPARATOR);

$yii = dirname(__FILE__) . '/../library/framework/yii.php';
$config = dirname(__FILE__) . '/../protected/config/main.php';
$short = dirname(__FILE__) . '/../library/shortcut.php';

require_once($yii);
require_once($short);

$app = Yii::createWebApplication($config);
$app->run();
