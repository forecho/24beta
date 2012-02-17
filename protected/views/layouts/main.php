<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="content-type" content="text/html; charset=<?php echo app()->charset?>" />
    <title><?php echo $this->pageTitle;?></title>
    <meta name="author" content="24beta.com" />
    <meta name="copyright" content="Copyright (c) 2009-2012 24beta.com All Rights Reserved." />
    <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
    <link media="screen" rel="stylesheet" type="text/css" href="<?php echo tbu('styles/beta-all.css');?>" />
    <script type="text/javascript" src="<?php echo sbu('libs/jquery-1.7.1.min.js');?>"></script>
</head>
<body>
<div class="beta-container">
    <div class="beta-header">
            <div class="beta-logo"><a href="<?php echo abu();?>"><?php echo app()->name;?></a></div>
    </div>
    <div class="beta-nav">
        <ul class="channel-nav fleft">
            <li><a href="<?php echo app()->homeUrl;?>">首页</a></li>
            <li><a href="<?php echo app()->homeUrl;?>">快讯</a></li>
            <li><a href="<?php echo app()->homeUrl;?>">主题</a></li>
            <li><a href="<?php echo app()->homeUrl;?>">事件</a></li>
            <li><a href="<?php echo app()->homeUrl;?>">团队</a></li>
            <li><a href="<?php echo app()->homeUrl;?>">开源</a></li>
            <br class="clear" />
        </ul>
        <ul class="user-mini-bar fright">
            <?php echo $this->userMiniToolbar();?>
            <br class="clear" />
        </ul>
        <br class="clear" />
    </div>
        <div class="beta-entry">
            <?php echo $content;?>
        </div>
    <div class="beta-footer">
        footer
    </div>
</div>
<a class="beta-backtop" href="#top"><?php echo t('return_top');?></a>
</body>
</html>

<?php cs()->registerScriptFile(tbu('scripts/beta-main.js'), CClientScript::POS_END);?>
