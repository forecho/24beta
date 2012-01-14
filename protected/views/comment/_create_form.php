<?php echo CHtml::form('',  'post', array('id'=>'comment-form', 'class'=>'comment-form'));?>
<?php echo CHtml::activeHiddenField($comment, 'post_id');?>
<div class="clearfix comment-clearfix">
    <label><?php echo t('your_name');?></label>
    <div class="input comment-input">
        <?php echo CHtml::activeTextField($comment, 'user_name');?>
        <span class="help-inline">您的大名会显示在评论处</span>
    </div>
</div>
<div class="clearfix comment-clearfix">
    <label><?php echo t('your_site');?></label>
    <div class="input comment-input">
        <?php echo CHtml::activeTextField($comment, 'user_site');?>
        <span class="help-inline">您的网站会以链接的形式显示在评论处</span>
    </div>
</div>
<div class="clearfix comment-clearfix">
    <label><?php echo t('your_email');?></label>
    <div class="input comment-input">
        <?php echo CHtml::activeTextField($comment, 'user_email');?>
        <span class="help-inline">您的邮箱只做发送通知使用</span>
    </div>
</div>
<div class="clearfix comment-clearfix">
    <label><?php echo t('comment_content');?></label>
    <div class="input comment-input">
        <?php echo CHtml::activeTextArea($comment, 'content', array('class'=>'span7', 'rows'=>5));?>
        <span class="help-block">评论内容不能少于10个字哦～～～</span>
    </div>
</div>
<div class="clearfix comment-clearfix">
    <label><?php echo t('captcha');?></label>
    <div class="input comment-input">
        <?php echo CHtml::activeTextField($comment, 'captcha', array('class'=>'beta-captcha input-mini'));?>
        <?php $this->widget('CCaptcha');?>
    </div>
</div>
<div class="actions">
    <?php echo CHtml::submitButton(t('submit'), array('class'=>'btn primary'));?>
    <?php echo CHtml::button(t('close'), array('class'=>'btn'));?>
</div>
<?php echo CHtml::endForm();?>