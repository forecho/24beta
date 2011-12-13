<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo app()->charset;?>" />
<title><?php echo app()->name . t('control_center', 'admin');?></title>
</head>
<frameset cols="120,*" border="1" framespacing="1" frameborder="1" noresize="noresize">
    <frame src="<?php echo url('admin/default/sidebar');?>" name="sidebar" scrolling="no" />
    <frame src="<?php echo url('admin/default/welcome');?>" name="main" />
    <noframes>
    <body>
    <p>This page uses frames. The current browser you are using does not support frames.</p>
    </body>
    </noframes>
</frameset>
</html>