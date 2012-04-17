<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo app()->charset;?>" />
<title><?php echo app()->name . t('control_center', 'admin');?></title>
<link rel="stylesheet" type="text/css" href="<?php echo sbu('libs/bootstrap/css/bootstrap.min.css');?>" />
<link rel="stylesheet" type="text/css" href="<?php echo sbu('styles/beta-admin.css');?>" />
<script type="text/javascript" src="<?php echo sbu('libs/jquery-1.7.1.min.js');?>"></script>
<script type="text/javascript">
/*<![CDATA[*/
var BETA_YES = <?php echo BETA_YES;?>;
var BETA_NO = <?php echo BETA_NO;?>;
$(function(){
	$('[rel=tooltip]').tooltip();
});
/*]]>*/
</script>
</head>
<body>
<div class="beta-container">
<?php echo $content;?>
</div>
</body>
</html>

<?php cs()->registerScriptFile(sbu('libs/bootstrap/js/bootstrap.min.js'), CClientScript::POS_END);?>
<?php cs()->registerScriptFile(sbu('scripts/beta-admin.js'), CClientScript::POS_END);?>