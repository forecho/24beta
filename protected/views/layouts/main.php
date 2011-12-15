<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="content-type" content="text/html; charset=<?php echo app()->charset?>" />
    <title><?php echo $this->pageTitle;?></title>
    <meta name="author" content="24beta.com" />
    <meta name="copyright" content="Copyright (c) 2009-2012 24beta.com All Rights Reserved." />
    <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
    <link media="screen" rel="stylesheet" type="text/css" href="<?php echo tbu('styles/beta-global.css');?>" />
    <link media="screen" rel="stylesheet" type="text/css" href="<?php echo tbu('styles/beta-main.css');?>" />
    <script type="text/javascript" src="<?php echo sbu('libs/jquery-1.7.1.min.js');?>"></script>
</head>
<body>
<div class="container beta-container">
    <div class="beta-header">
        <div class="beta-logo"><img src="<?php echo tbu('images/logo.png');?>" alt="<?php echo app()->name;?> LOGO" /></div>
    </div>
    <div class="beta-entry">
        <?php echo $content;?>
    </div>
    <div class="beta-footer">
        footer
    </div>
</div>
</body>
</html>

<?php cs()->registerScriptFile(tbu('scripts/beta-main.js'), CClientScript::POS_END);?>
