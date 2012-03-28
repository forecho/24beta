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
    <div class="well well-small">
        <div class="btn-group">
            <?php echo l(t('latest_comment_in_hours', 'admin', array('{hours}'=>8)), url('admin/comment/latest', array('hours'=>12)), array('class'=>'btn btn-small'));?>
            <a class="btn btn-small dropdown-toggle" data-toggle="dropdown" href="#">
                <span class="caret"></span>
            </a>
            <ul class="dropdown-menu dropdown-menu-small">
                <li><?php echo l(t('latest_comment_in_hours', 'admin', array('{hours}'=>12)), url('admin/comment/latest', array('hours'=>12)));?></li>
                <li><?php echo l(t('latest_comment_in_hours', 'admin', array('{hours}'=>18)), url('admin/comment/latest', array('hours'=>18)));?></li>
                <li><?php echo l(t('latest_comment_in_hours', 'admin', array('{hours}'=>24)), url('admin/comment/latest', array('hours'=>24)));?></li>
            </ul>
        </div>
        <div class="btn-group">
            <?php echo l(t('recommend_comment', 'admin', array('{count}'=>10)), url('admin/comment/recommend', array('count'=>10)), array('class'=>'btn btn-small'));?>
            <a class="btn btn-small dropdown-toggle" data-toggle="dropdown" href="#">
                <span class="caret"></span>
            </a>
            <ul class="dropdown-menu dropdown-menu-small">
                <li><?php echo l(t('recommend_comment', 'admin', array('{count}'=>20)), url('admin/comment/recommend', array('count'=>20)));?></li>
                <li><?php echo l(t('recommend_comment', 'admin', array('{count}'=>30)), url('admin/comment/recommend', array('count'=>30)));?></li>
                <li><?php echo l(t('recommend_comment', 'admin', array('{count}'=>50)), url('admin/comment/recommend', array('count'=>50)));?></li>
            </ul>
        </div>
        <div class="btn-group"><?php echo l(t('verify_comment', 'admin'), url('admin/comment/verify'), array('class'=>'btn btn-small'));?></div>
        <div class="btn-group"><?php echo l(t('search_comment', 'admin'), url('admin/comment/search'), array('class'=>'btn btn-small'));?></div>
    </div>

    <?php echo $content;?>

</div>
</body>
</html>

<?php cs()->registerScriptFile(sbu('libs/bootstrap/js/bootstrap.min.js'), CClientScript::POS_END);?>
<?php cs()->registerScriptFile(sbu('scripts/beta-admin.js'), CClientScript::POS_END);?>