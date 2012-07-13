<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>24Blog 安装向导</title>
    <link media="screen" rel="stylesheet" type="text/css" href="./res/beta-install.css" />
    <script type="text/javascript" src="./res/jquery-1.7.2.min.js"></script>
    <script type="text/javascript" src="./res/beta-install.js"></script>
</head>
<body>
<div class="beta-container">
    <div class="beta-header">
        <h2>24Blog 安装向导</h2>
    </div>
    <ul class="beta-nav">
        <li <?php echo $step == 0 ? 'class="active"' : '';?>>24Blog安装向导</li>
        <li <?php echo $step == 1 ? 'class="active"' : '';?>>第一步：检测系统环境</li>
        <li <?php echo $step == 2 ? 'class="active"' : '';?>>第二步：填写网站基本信息</li>
        <li <?php echo $step == 3 ? 'class="active"' : '';?>>第三步：安装完成</li>
        <div class="clear"></div>
    </ul>
    <div class="beta-entry">