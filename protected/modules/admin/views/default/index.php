<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo app()->charset;?>" />
<title><?php echo app()->name . t('control_center', 'admin');?></title>
<link rel="stylesheet" type="text/css" href="<?php echo sbu('libs/bootstrap/css/bootstrap.min.css');?>" />
<link rel="stylesheet" type="text/css" href="<?php echo sbu('styles/beta-admin.css');?>" />
<script type="text/javascript" src="<?php echo sbu('libs/jquery-1.7.1.min.js');?>"></script>
</head>
<body>
<div class="navbar navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container admin-nav-container">
            <a class="brand" href="<?php echo url('admin/default/welcome');?>" target="main">24Beta<?php echo t('control_center', 'admin');?></a>
            <ul class="nav">
                <li class="divider-vertical"></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo t('post_manage', 'admin');?><b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><?php echo l(t('create_posts', 'admin'), url('admin/post/createpost'), array('target'=>'main'));?></li>
                        <li><?php echo l(t('verify_posts', 'admin'), url('admin/post/verify'), array('target'=>'main'));?></li>
                        <li><?php echo l(t('search_posts', 'admin'), url('admin/post/search'), array('target'=>'main'));?></li>
                        <li class="divider"></li>
                        <li><?php echo l(t('latest_posts', 'admin'), url('admin/post/latest'), array('target'=>'main'));?></li>
                        <li><?php echo l(t('hottest_posts', 'admin'), url('admin/post/hottest'), array('target'=>'main'));?></li>
                        <li><?php echo l(t('editor_recommend_posts', 'admin'), url('admin/post/recommend'), array('target'=>'main'));?></li>
                        <li><?php echo l(t('home_show_posts', 'admin'), url('admin/post/homeshow'), array('target'=>'main'));?></li>
                        <li class="divider"></li>
                        <li class="nav-header">附件</li>
                        <li><?php echo l(t('upload_file_search', 'admin'), url('admin/upload/search'), array('target'=>'main'));?></li>
                        <li><?php echo l(t('upload_file_list', 'admin'), url('admin/upload/list'), array('target'=>'main'));?></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo t('topic_category', 'admin');?><b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li class="nav-header"><?php echo t('post_topic', 'admin');?></li>
                        <li><?php echo l(t('create_topic', 'admin'), url('admin/topic/create'), array('target'=>'main'));?></li>
                        <li><?php echo l(t('topic_list_table', 'admin'), url('admin/topic/list'), array('target'=>'main'));?></li>
                        <!-- <li><?php echo l(t('topic_statistics', 'admin'), url('admin/topic/statistics'), array('target'=>'main'));?></li> -->
                        <li class="divider"></li>
                        <li class="nav-header"><?php echo t('post_category', 'admin');?></li>
                        <li><?php echo l(t('create_category', 'admin'), url('admin/category/create'), array('target'=>'main'));?></li>
                        <li><?php echo l(t('category_list_table', 'admin'), url('admin/category/list'), array('target'=>'main'));?></li>
                        <!-- <li><?php echo l(t('category_statistics', 'admin'), url('admin/category/statistics'), array('target'=>'main'));?></li> -->
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo t('comment_manage', 'admin');?><b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li class="nav-header"><?php echo t('comment_manage', 'admin');?></li>
                        <li><?php echo l(t('latest_comment', 'admin'), url('admin/comment/latest'), array('target'=>'main'));?></li>
                        <li><?php echo l(t('verify_comment', 'admin'), url('admin/comment/verify'), array('target'=>'main'));?></li>
                        <li><?php echo l(t('recommend_comment', 'admin'), url('admin/comment/recommend'), array('target'=>'main'));?></li>
                        <li><?php echo l(t('search_comment', 'admin'), url('admin/comment/search'), array('target'=>'main'));?></li>
                        <li class="divider"></li>
                        <li class="nav-header"><?php echo t('post_tag', 'admin');?></li>
                        <li><?php echo l(t('hottest_tags', 'admin'), url('admin/tag/hottest'), array('target'=>'main'));?></li>
                        <li><?php echo l(t('tag_search', 'admin'), url('admin/tag/search'), array('target'=>'main'));?></li>
                    </ul>
                </li>
                <li class="divider-vertical"></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo t('user_manage', 'admin');?><b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><?php echo l(t('create_user', 'admin'), url('admin/user/create'), array('target'=>'main'));?></li>
                        <li><?php echo l(t('verify_user', 'admin'), url('admin/user/verify'), array('target'=>'main'));?></li>
                        <li><?php echo l(t('search_user', 'admin'), url('admin/user/search'), array('target'=>'main'));?></li>
                        <li class="divider"></li>
                        <li class="nav-header"><?php echo t('statistics', 'admin');?></li>
                        <!-- <li><?php echo l(t('most_active_users', 'admin'), url('admin/user/mostactive', array('day'=>14)), array('target'=>'main'));?></li> -->
                        <li><?php echo l(t('today_signup', 'admin'), url('admin/user/today'), array('target'=>'main'));?></li>
                        <!-- <li><?php echo l(t('user_statistics', 'admin'), url('admin/user/statistics'), array('target'=>'main'));?></li> -->
                    </ul>
                </li>
                <!--
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo t('system_tool', 'admin');?><b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li class="nav-header">广告</li>
                        <li><a href="#">广告单元</a></li>
                        <li><a href="#">自建广告</a></li>
                        <li class="divider"></li>
                        <li class="nav-header">数据</li>
                        <li><a href="#">备份</a></li>
                        <li><a href="#">恢复</a></li>
                    </ul>
                </li>
                 -->
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo t('system_setting', 'admin');?><b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li class="nav-header"><?php echo t('system_config_params', 'admin');?></li>
                        <li><?php echo l(t('system_site', 'admin'), url('admin/config/view', array('categoryid'=>AdminConfig::CATEGORY_SYSTEM_SITE)), array('target'=>'main'));?></li>
                        <li><?php echo l(t('system_rewrite', 'admin'), url('admin/config/view', array('categoryid'=>AdminConfig::CATEGORY_SYSTEM_REWRITE)), array('target'=>'main'));?></li>
                        <li><?php echo l(t('system_cache', 'admin'), url('admin/config/view', array('categoryid'=>AdminConfig::CATEGORY_SYSTEM_CACHE)), array('target'=>'main'));?></li>
                        <li><?php echo l(t('system_attachments', 'admin'), url('admin/config/view', array('categoryid'=>AdminConfig::CATEGORY_SYSTEM_ATTACHMENTS)), array('target'=>'main'));?></li>
                        <li class="divider"></li>
                        <li class="nav-header"><?php echo t('display_config_params', 'admin');?></li>
                        <li><?php echo l(t('display_template', 'admin'), url('admin/config/view', array('categoryid'=>AdminConfig::CATEGORY_DISPLAY_TEMPLATE)), array('target'=>'main'));?></li>
                        <li><?php echo l(t('display_ui', 'admin'), url('admin/config/view', array('categoryid'=>AdminConfig::CATEGORY_DISPLAY_UI)), array('target'=>'main'));?></li>
                        <li class="divider"></li>
                        <li class="nav-header"><?php echo t('sns_config_params', 'admin');?></li>
                        <li><?php echo l(t('sns_interface', 'admin'), url('admin/config/view', array('categoryid'=>AdminConfig::CATEGORY_SNS_INTERFACE)), array('target'=>'main'));?></li>
                        <li><?php echo l(t('sns_stats', 'admin'), url('admin/config/view', array('categoryid'=>AdminConfig::CATEGORY_SNS_STATS)), array('target'=>'main'));?></li>
                        <li><?php echo l(t('sns_template', 'admin'), url('admin/config/view', array('categoryid'=>AdminConfig::CATEGORY_SNS_TEMPLATE)), array('target'=>'main'));?></li>
                        <li class="divider"></li>
                        <li class="nav-header"><?php echo t('custom_config_params', 'admin');?></li>
                        <li><?php echo l(t('custom_config_params', 'admin'), url('admin/config/view', array('categoryid'=>AdminConfig::CATEGORY_CUSTOM)), array('target'=>'main'));?></li>
                        <li><?php echo l(t('create_custom_param', 'admin'), url('admin/config/create'), array('target'=>'main'));?></li>
                    </ul>
                </li>
                <li class="divider-vertical"></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo t('system_about', 'admin')?><b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><?php echo l(t('about_us', 'admin'), url('admin/static/intro'), array('target'=>'main'));?></li>
                        <li><?php echo l(t('our_team', 'admin'), url('admin/static/team'), array('target'=>'main'));?></li>
                        <li><?php echo l(t('provision', 'admin'), url('admin/static/provision'), array('target'=>'main'));?></li>
                    </ul>
                </li>
            </ul>
            <ul class="nav pull-right">
                <li><?php echo l(user()->name, url('admin/user/current'), array('target'=>'main'));?></li>
                <li><?php echo l(t('logout_control_center', 'admin'), url('site/logout'));?></li>
                <li><?php echo l(t('site_home', 'admin'), url('site/index'), array('target'=>'_blank'));?></li>
            </ul>
        </div>
    </div>
</div>
<div class="well admin-sidebar">
    <ul class="nav nav-list">
        <li class="nav-header"><?php echo t('article', 'admin');?></li>
        <li><?php echo l(t('create_posts', 'admin'), url('admin/post/createpost'), array('target'=>'main'));?></li>
        <li><?php echo l(t('verify_posts', 'admin'), url('admin/post/verify'), array('target'=>'main'));?></li>
        <li><?php echo l(t('latest_posts', 'admin'), url('admin/post/latest'), array('target'=>'main'));?></li>
        <li><?php echo l(t('search_posts', 'admin'), url('admin/post/search'), array('target'=>'main'));?></li>
        <li class="nav-header"><?php echo t('post_comment', 'admin');?></li>
        <li><?php echo l(t('verify_comment', 'admin'), url('admin/comment/verify'), array('target'=>'main'));?></li>
        <li><?php echo l(t('latest_comment', 'admin'), url('admin/comment/latest'), array('target'=>'main'));?></li>
        <li class="nav-header"><?php echo t('user_manage', 'admin');?></li>
        <li><?php echo l(t('verify_user', 'admin'), url('admin/user/verify'), array('target'=>'main'));?></li>
        <li><?php echo l(t('today_signup', 'admin'), url('admin/user/today'), array('target'=>'main'));?></li>
    </ul>
</div>
<div class="admin-container">
    <iframe id="admin-iframe" src="<?php echo url('admin/default/welcome');?>" name="main"></iframe>
</div>
<script type="text/javascript" src="<?php echo sbu('libs/bootstrap/js/bootstrap.min.js');?>"></script>
<script type="text/javascript" src="<?php echo sbu('scripts/beta-admin.js');?>"></script>
</body>
</html>



