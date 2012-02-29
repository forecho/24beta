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
<div class="beta-container">
    <div class="well btn-toolbar">
        <div class="btn-group"><?php echo l(t('create_posts', 'admin'), url('admin/post/create'), array('class'=>'btn btn-small'));?></div>
        <div class="btn-group"><?php echo l(t('verify_posts', 'admin'), url('admin/post/verify'), array('class'=>'btn btn-small'));?></div>
        <div class="btn-group"><?php echo l(t('today_posts', 'admin'), url('admin/post/today'), array('class'=>'btn btn-small'));?></div>
        <div class="btn-group"><?php echo l(t('search_posts', 'admin'), url('admin/post/search'), array('class'=>'btn btn-small'));?></div>
        <div class="btn-group"><?php echo l(t('hottest_posts', 'admin'), url('admin/post/hottest'), array('class'=>'btn btn-small'));?></div>
        <div class="btn-group"><?php echo l(t('editor_recommend_posts', 'admin'), url('admin/post/recommend'), array('class'=>'btn btn-small'));?></div>
        <div class="btn-group"><?php echo l(t('has_deleted_posts', 'admin'), url('admin/post/deleted'), array('class'=>'btn btn-small'));?></div>
    </div>

    <?php echo $content;?>

</div>
</body>
</html>

<?php cs()->registerScriptFile(sbu('libs/bootstrap/js/bootstrap.min.js'), CClientScript::POS_END);?>
<?php cs()->registerScriptFile(sbu('scripts/beta-admin.js'), CClientScript::POS_END);?>