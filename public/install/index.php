<?php
define('DS', DIRECTORY_SEPARATOR);
define('PATH_ROOT', dirname(__FILE__) . DS);
require PATH_ROOT . 'inc' . DS . 'common.inc.php';

$step = (int)$_GET['step'];
if ($step >= 1 && $step <= 3)
    $file = 'step' . $step . '.php';
else
    $file = 'index.php';
$viewFile =  PATH_ROOT . 'views' . DS . $file;
$data = array('step' => $step);

switch ($step)
{
    case 1:
        require PATH_ROOT . 'inc' . DS . 'step1.php';
        $data['result'] = $result;
        $data['requirements'] = $requirements;
        break;
    case 2:
        break;
    case 3:
        break;
    default:
        break;
}

renderFile($viewFile, $data);