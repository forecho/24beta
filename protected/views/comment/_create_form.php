<div class="alert beta-alert-message hide" id="beta-create-message" data-dismiss="alert"><a class="close" href="javascript:void(0);">&times;</a><span class="text">您的大名会显示在评论处</span></div>
<?php echo CHtml::form(aurl('post/comment'),  'post', array('class'=>'form-horizontal comment-form', 'id'=>'comment-form'));?>
<?php echo CHtml::activeHiddenField($comment, 'post_id');?>
<div class="control-group comment-clearfix">
    <label><?php echo t('your_name');?></label>
    <div class="input comment-input">
        <?php echo CHtml::activeTextField($comment, 'user_name', array('class'=>'user-name'));?>
        <span class="help-info help-inline">您的大名会显示在评论处</span>
        <span class="help-error help-inline">名字太长</span>
    </div>
</div>
<div class="control-group comment-clearfix">
    <label><?php echo t('your_site');?></label>
    <div class="input comment-input">
        <?php echo CHtml::activeTextField($comment, 'user_site', array('class'=>'user-site'));?>
        <span class="help-info help-inline">您的网站会以链接的形式显示在评论处</span>
        <span class="help-error help-inline">网址太长或不符合规则</span>
    </div>
</div>
<div class="control-group comment-clearfix">
    <label><?php echo t('your_email');?></label>
    <div class="input comment-input">
        <?php echo CHtml::activeTextField($comment, 'user_email', array('class'=>'user-email'));?>
        <span class="help-info help-inline">您的邮箱只做发送通知使用</span>
        <span class="help-error help-inline">邮箱太长或不符合规则</span>
    </div>
</div>
<div class="control-group comment-clearfix">
    <label><?php echo t('comment_content');?></label>
    <div class="input comment-input">
        <?php echo CHtml::activeTextArea($comment, 'content', array('class'=>'span6 comment-content', 'rows'=>4, 'minlen'=>param('commentMinLength')));?>
        <p class="help-info help-block">评论内容不能少于10个字哦～～～</p>
    </div>
</div>
<div class="control-group comment-clearfix comment-captcha hide">
    <label><?php echo t('captcha');?></label>
    <div class="input comment-input">
        <?php echo CHtml::activeTextField($comment, 'captcha', array('class'=>'beta-captcha input-mini'));?>
        <?php $this->widget('BetaCaptcha', array('skin'=>'comment'));?>
        <a href="<?php echo url('post/captcha', array('refresh'=>1));?>" class="refresh-captcha" tabindex="99999"><?php echo t('refresh_captcha');?></a>
        <span class="help-info help-inline">4位纯数字</span>
        <span class="help-error help-inline">验证码不正确</span>
    </div>
</div>
<div class="form-actions">
    <?php echo CHtml::button(t('submit'), array('class'=>'btn btn-primary commit-submit'));?>
    <?php echo CHtml::resetButton(t('reset'), array('class'=>'btn'));?>
</div>
<?php echo CHtml::endForm();?>

<script type="text/javascript">
$(function(){
	$(document).on('click', '.comment-form .commit-submit', BetaComment.create);
	$(document).on('blur', '.comment-form .user-name', BetaComment.usernameValidate);
	$(document).on('blur', '.comment-form .user-site', BetaComment.siteValidate);
	$(document).on('blur', '.comment-form .user-email', BetaComment.emailValidate);
	$(document).on('blur', '.comment-form .beta-captcha', BetaComment.captchaValidate);
	$(document).on('blur', '.comment-form .comment-content', BetaComment.contentValidate);
	$(document).on('focus', '.comment-form .comment-content', BetaComment.showCaptcha);
	$(document).on('click', '.beta-captcha-img, .refresh-captcha', BetaComment.refreshCaptcha);
});
</script>


