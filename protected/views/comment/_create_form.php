<div class="beta-alert beta-alert-message hide" id="beta-create-message" data-dismiss="alert"><a class="close" href="javascript:void(0);">&times;</a><span class="text">您的大名会显示在评论处</span></div>
<?php echo CHtml::form(aurl('post/comment'),  'post', array('class'=>'beta-form-horizontal beta-comment-form', 'id'=>'comment-form'));?>
<?php echo CHtml::activeHiddenField($comment, 'post_id');?>
<div class="beta-control-group">
    <label class="beta-control-label"><?php echo t('your_name');?></label>
    <div class="beta-controls comment-input">
        <?php echo CHtml::activeTextField($comment, 'user_name', array('class'=>'beta-text user-name'));?>
        <span class="beta-help-info beta-help-inline">您的大名会显示在评论处</span>
        <span class="beta-help-error beta-help-inline">名字太长</span>
    </div>
</div>
<div class="beta-control-group">
    <label class="beta-control-label"><?php echo t('your_site');?></label>
    <div class="beta-controls comment-input">
        <?php echo CHtml::activeTextField($comment, 'user_site', array('class'=>'beta-text user-site'));?>
        <span class="beta-help-info beta-help-inline">您的网站会以链接的形式显示在评论处</span>
        <span class="beta-help-error beta-help-inline">网址太长或不符合规则</span>
    </div>
</div>
<div class="beta-control-group">
    <label class="beta-control-label"><?php echo t('your_email');?></label>
    <div class="beta-controls comment-input">
        <?php echo CHtml::activeTextField($comment, 'user_email', array('class'=>'beta-text user-email'));?>
        <span class="beta-help-info beta-help-inline">您的邮箱只做发送通知使用</span>
        <span class="beta-help-error beta-help-inline">邮箱太长或不符合规则</span>
    </div>
</div>
<div class="beta-control-group">
    <label class="beta-control-label"><?php echo t('comment_content');?></label>
    <div class="beta-controls comment-input">
        <?php echo CHtml::activeTextArea($comment, 'content', array('class'=>'comment-content', 'rows'=>4, 'minlen'=>param('commentMinLength')));?>
        <p class="beta-help-info beta-help-block">评论内容不能少于10个字哦～～～</p>
    </div>
</div>
<div class="beta-control-group comment-captcha hide">
    <label class="beta-control-label"><?php echo t('captcha');?></label>
    <div class="beta-controls comment-input">
        <?php echo CHtml::activeTextField($comment, 'captcha', array('class'=>'beta-text beta-captcha'));?>
        <?php $this->widget('BetaCaptcha', array('skin'=>'comment'));?>
        <a href="<?php echo url('post/captcha', array('refresh'=>1));?>" class="refresh-captcha" tabindex="99999"><?php echo t('refresh_captcha');?></a>
        <span class="beta-help-info beta-help-inline">4位纯数字</span>
        <span class="beta-help-error beta-help-inline">验证码不正确</span>
    </div>
</div>
<div class="beta-form-actions">
    <?php echo CHtml::button(t('submit'), array('class'=>'beta-btn btn-primary commit-submit'));?>
</div>
<?php echo CHtml::endForm();?>

<script type="text/javascript">
$(function(){
	$(document).on('click', '.beta-comment-form .commit-submit', BetaComment.create);
	$(document).on('blur', '.beta-comment-form .user-name', BetaComment.usernameValidate);
	$(document).on('blur', '.beta-comment-form .user-site', BetaComment.siteValidate);
	$(document).on('blur', '.beta-comment-form .user-email', BetaComment.emailValidate);
	$(document).on('blur', '.beta-comment-form .beta-captcha', BetaComment.captchaValidate);
	$(document).on('blur', '.beta-comment-form .comment-content', BetaComment.contentValidate);
	$(document).on('focus', '.beta-comment-form .comment-content', BetaComment.showCaptcha);
	$(document).on('click', '.beta-captcha-img, .refresh-captcha', BetaComment.refreshCaptcha);
});
</script>


