<div class="beta-alert beta-alert-message hide" id="beta-create-message" data-dismiss="alert"><a class="close" href="javascript:void(0);">&times;</a><span class="text">您的大名会显示在评论处</span></div>
<?php echo CHtml::form(aurl('post/comment'),  'post', array('class'=>'beta-form-horizontal beta-comment-form', 'id'=>'comment-form'));?>
<?php echo CHtml::activeHiddenField($comment, 'post_id');?>
<div class="beta-control-group stacked">
    <div class="beta-controls comment-input">
        <p class="beta-help-info beta-help-block"><?php echo t('comment_content_min_length', 'main', array('{minlength}'=>param('commentMinLength')));?></p>
        <?php echo CHtml::activeTextArea($comment, 'content', array('class'=>'comment-content mini', 'rows'=>4, 'minlen'=>param('commentMinLength')));?>
    </div>
    <div class="clear"></div>
</div>
<div class="beta-control-group comment-captcha hide">
    <label class="beta-control-label"><?php echo t('captcha');?></label>
    <div class="beta-controls comment-input">
        <?php echo CHtml::activeTextField($comment, 'captcha', array('class'=>'beta-text beta-captcha'));?>
        <?php $this->widget('BetaCaptcha', array('skin'=>'comment'));?>
        <a href="<?php echo url('post/captcha', array('refresh'=>1));?>" class="refresh-captcha" tabindex="99999"><?php echo t('refresh_captcha');?></a>
    </div>
    <div class="clear"></div>
</div>
<div class="acenter">
    <?php echo CHtml::submitButton(t('submit'), array('class'=>'beta-btn btn-primary commit-submit'));?>
</div>
<?php echo CHtml::endForm();?>

<script type="text/javascript">
$(function(){
	$(document).on('submit', '.beta-comment-form', BetaComment.create);
	$(document).on('blur', '.beta-comment-form .beta-captcha', BetaComment.captchaValidate);
	$(document).on('blur', '.beta-comment-form .comment-content', BetaComment.contentValidate);
	$(document).on('focus', '.beta-comment-form .comment-content', BetaComment.showCaptcha);
	$(document).on('click', '.beta-captcha-img, .refresh-captcha', BetaComment.refreshCaptcha);
});
</script>


