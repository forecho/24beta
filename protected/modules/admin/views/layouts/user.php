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
            <?php echo l(t('most_active_users', 'admin'), url('admin/user/mostactive', array('day'=>1)), array('class'=>'btn btn-small'));?>
            <a class="btn btn-small dropdown-toggle" data-toggle="dropdown" href="#">
                <span class="caret"></span>
            </a>
            <ul class="dropdown-menu dropdown-menu-small">
                <li><?php echo l(t('one_day', 'admin'), url('admin/user/mostactive', array('day'=>1)));?></li>
                <li><?php echo l(t('one_week', 'admin'), url('admin/user/mostactive', array('day'=>7)));?></li>
                <li><?php echo l(t('one_month', 'admin'), url('admin/user/mostactive', array('day'=>30)));?></li>
            </ul>
        </div>
        <div class="btn-group"><?php echo l(t('today_signup', 'admin'), url('admin/user/today'), array('class'=>'btn btn-small'));?></div>
        <div class="btn-group"><?php echo l(t('create_user', 'admin'), url('admin/user/create'), array('class'=>'btn btn-small'));?></div>
        <div class="btn-group"><?php echo l(t('verify_user', 'admin'), url('admin/user/verify'), array('class'=>'btn btn-small'));?></div>
        <div class="btn-group"><?php echo l(t('search_user', 'admin'), url('admin/user/search'), array('class'=>'btn btn-small'));?></div>
    </div>

    <?php echo $content;?>

</div>
</body>
</html>

<?php cs()->registerScriptFile(sbu('libs/bootstrap/js/bootstrap.min.js'), CClientScript::POS_END);?>
<?php cs()->registerScriptFile(sbu('scripts/beta-admin.js'), CClientScript::POS_END);?>