<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="content-type" content="text/html; charset=<?php echo app()->charset?>" />
    <title><?php echo $this->pageTitle;?></title>
    <link media="screen" rel="stylesheet" type="text/css" href="<?php echo sbu('styles/beta-install.css');?>" />
    <script type="text/javascript" src="<?php echo sbu('libs/jquery-1.7.2.min.js');?>"></script>
    <?php echo param('header_html');?>
</head>
<body>
<div class="beta-container">
    <div class="beta-header">
        <h2>24Blog 安装向导</h2>
    </div>
    <ul class="beta-nav">
        <li <?php echo $this->step == 0 ? 'class="active"' : '';?>>24Blog安装向导</li>
        <li <?php echo $this->step == 1 ? 'class="active"' : '';?>>第一步：检测系统环境</li>
        <li <?php echo $this->step == 2 ? 'class="active"' : '';?>>第二步：填写网站基本信息</li>
        <li <?php echo $this->step == 3 ? 'class="active"' : '';?>>第三步：安装完成</li>
        <div class="clear"></div>
    </ul>
    <div class="beta-entry">
        <?php echo $content;?>
    </div>
</div>
</body>
</html>

<?php cs()->registerScriptFile(sbu('scripts/beta-install.js'), CClientScript::POS_END);?>
