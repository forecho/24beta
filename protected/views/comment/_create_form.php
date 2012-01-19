<?php echo CHtml::form(aurl('comment/create'),  'post', array('class'=>'comment-form'));?>
<?php echo CHtml::activeHiddenField($comment, 'post_id');?>
<div class="clearfix comment-clearfix">
    <label><?php echo t('your_name');?></label>
    <div class="input comment-input">
        <?php echo CHtml::activeTextField($comment, 'user_name', array('class'=>'user-name'));?>
        <span class="help-info help-inline">您的大名会显示在评论处</span>
        <span class="help-error help-inline">名字太长</span>
    </div>
</div>
<div class="clearfix comment-clearfix">
    <label><?php echo t('your_site');?></label>
    <div class="input comment-input">
        <?php echo CHtml::activeTextField($comment, 'user_site', array('class'=>'user-site'));?>
        <span class="help-info help-inline">您的网站会以链接的形式显示在评论处</span>
        <span class="help-error help-inline">网址太长或不符合规则</span>
    </div>
</div>
<div class="clearfix comment-clearfix">
    <label><?php echo t('your_email');?></label>
    <div class="input comment-input">
        <?php echo CHtml::activeTextField($comment, 'user_email', array('class'=>'user-email'));?>
        <span class="help-info help-inline">您的邮箱只做发送通知使用</span>
        <span class="help-error help-inline">邮箱太长或不符合规则</span>
    </div>
</div>
<div class="clearfix comment-clearfix">
    <label><?php echo t('comment_content');?></label>
    <div class="input comment-input">
        <?php echo CHtml::activeTextArea($comment, 'content', array('class'=>'span7 comment-content', 'rows'=>4, 'minlen'=>param('commentMinLength')));?>
        <span class="help-info help-block">评论内容不能少于10个字哦～～～</span>
    </div>
</div>
<div class="clearfix comment-clearfix comment-captcha">
    <label><?php echo t('captcha');?></label>
    <div class="input comment-input">
        <?php echo CHtml::activeTextField($comment, 'captcha', array('class'=>'beta-captcha input-mini'));?>
        <?php $this->widget('CCaptcha');?>
        <span class="help-info help-inline">4位纯数字</span>
        <span class="help-error help-inline">验证码不正确</span>
    </div>
</div>
<div class="actions">
    <?php echo CHtml::submitButton(t('submit'), array('class'=>'btn primary'));?>
    <?php echo CHtml::resetButton(t('reset'), array('class'=>'btn'));?>
</div>
<?php echo CHtml::endForm();?>
<div class="alert-message beta-alert-message hide"><a class="close" href="javascript:void(0);">×</a><span class="text"></span></div>
<div class="hide ajax-jsstr">
    <span class="ajax-send"><?php echo t('ajax_send');?></span>
    <span class="ajax-fail"><?php echo t('ajax_fail');?></span>
    <span class="ajax-rules-invalid"><?php echo t('ajax_comment_rules_invalid');?></span>
</div>

<script type="text/javascript">
$(function(){
	$('.comment-form .comment-content').focus();
	$('.comment-form').on('submit', BetaComment.create);
	$('.comment-form .user-name').on('blur', BetaComment.usernameValidate);
	$('.comment-form .user-site').on('blur', BetaComment.siteValidate);
	$('.comment-form .user-email').on('blur', BetaComment.emailValidate);
	$('.comment-form .beta-captcha').on('blur', BetaComment.captchaValidate);
	$('.comment-form .comment-content').on('blur', BetaComment.contentValidate);
});
</script>


