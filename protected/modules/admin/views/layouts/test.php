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
            <a class="brand" href="<?php echo app()->homeUrl;?>" target="_blank">24Beta</a>
            <ul class="nav">
                <li class="divider-vertical"></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">快捷操作<b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><?php echo l(t('new_post', 'admin'), url('admin/post/createpost'), array('target'=>'main'));?></li>
                        <li><a href="#">审核文章</a></li>
                        <li><a href="#">查询文章</a></li>
                        <li class="divider"></li>
                        <li><a href="#">最新文章</a></li>
                        <li><a href="#">首页热门</a></li>
                        <li><a href="#">编辑推荐</a></li>
                        <li><a href="#">首页显示</a></li>
                    </ul>
                </li>
                <li class="divider-vertical"></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">文章<b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="#">发布文章</a></li>
                        <li><a href="#">审核文章</a></li>
                        <li><a href="#">查询文章</a></li>
                        <li class="divider"></li>
                        <li><a href="#">最新文章</a></li>
                        <li><a href="#">首页热门</a></li>
                        <li><a href="#">编辑推荐</a></li>
                        <li><a href="#">首页显示</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">主题分类<b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li class="nav-header">主题</li>
                        <li><a href="#">新建主题</a></li>
                        <li><a href="#">主题列表</a></li>
                        <li class="divider"></li>
                        <li class="nav-header">分类</li>
                        <li><a href="#">新建分类</a></li>
                        <li><a href="#">分类列表</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">评论<b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li class="nav-header">评论</li>
                        <li><a href="#">最新评论</a></li>
                        <li><a href="#">审核评论</a></li>
                        <li><a href="#">推荐评论</a></li>
                        <li><a href="#">查询评论</a></li>
                        <li class="divider"></li>
                        <li class="nav-header">标签</li>
                        <li><a href="#">热门标签</a></li>
                        <li><a href="#">标签查询</a></li>
                        <li class="divider"></li>
                        <li class="nav-header">附件</li>
                        <li><a href="#">附件查询</a></li>
                        <li><a href="#">附件列表</a></li>
                    </ul>
                </li>
                <li class="divider-vertical"></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">用户<b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="#">创建</a></li>
                        <li><a href="#">审核</a></li>
                        <li><a href="#">搜索</a></li>
                        <li class="divider"></li>
                        <li class="nav-header">统计</li>
                        <li><a href="#">今日注册</a></li>
                        <li><a href="#">今日活跃</a></li>
                        <li><a href="#">14天活跃</a></li>
                        <li><a href="#">总体统计</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">工具<b class="caret"></b></a>
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
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">设置<b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li class="nav-header">系统功能</li>
                        <li><a href="#">网站设置</a></li>
                        <li><a href="#">伪静态</a></li>
                        <li><a href="#">缓存</a></li>
                        <li class="divider"></li>
                        <li class="nav-header">网站显示</li>
                        <li><a href="#">模板</a></li>
                        <li><a href="#">界面</a></li>
                        <li class="divider"></li>
                        <li class="nav-header">社会化分享</li>
                        <li><a href="#">接口设置</a></li>
                        <li><a href="#">数据统计</a></li>
                        <li><a href="#">模板</a></li>
                    </ul>
                </li>
                <li class="divider-vertical"></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">关于<b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="#">发布文章</a></li>
                        <li><a href="#">审核文章</a></li>
                        <li><a href="#">查询文章</a></li>
                        <li class="divider"></li>
                    </ul>
                </li>
            </ul>
            <ul class="nav pull-right">
                <li><a href="#"><?php echo user()->name;?></a></li>
                <li><a href="#">退出</a></li>
            </ul>
        </div>
    </div>
</div>
<div class="well admin-sidebar">
    <ul class="nav nav-list">
        <li class="nav-header">文章</li>
        <li><a href="#"><i class="icon-pencil"></i>&nbsp;发布</a></li>
        <li><a href="#"><i class="icon-eye-open"></i>&nbsp;审核</a></li>
        <li class="nav-header">评论</li>
        <li><a href="#"><i class="icon-eye-open"></i>&nbsp;审核</a></li>
        <li><a href="#"><i class="icon-time"></i>&nbsp;最新</a></li>
    </ul>
</div>
<div class="admin-container">
    <iframe id="admin-iframe" src="http://www.sina.com.cn" name="main"></iframe>
</div>
</body>
</html>

<?php cs()->registerScriptFile(sbu('libs/bootstrap/js/bootstrap.min.js'), CClientScript::POS_END);?>
<?php cs()->registerScriptFile(sbu('scripts/beta-admin.js'), CClientScript::POS_END);?>