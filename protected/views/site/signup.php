<div class="beta-content">
    <h2><?php echo t('welcome_signup');?></h2>
    <?php echo CHtml::form('', 'post', array('class'=>'login-form'));?>
    <div class="beta-control-group <?php echo $form->hasErrors('email') ? 'error' : '';?>">
        <label class="beta-control-label"><?php echo t('email');?></label>
        <div class="beta-controls">
            <?php echo CHtml::activeTextField($form, 'email', array('class'=>'beta-text', 'tabindex'=>1));?>
            <?php if ($form->hasErrors('email')):?><span class="beta-help-inline"><?php echo $form->getError('email');?></span><?php endif;?>
        </div>
        <div class="clear"></div>
    </div>
    <div class="beta-control-group <?php echo $form->hasErrors('username') ? 'error' : '';?>">
        <label class="beta-control-label"><?php echo t('username');?></label>
        <div class="beta-controls">
            <?php echo CHtml::activeTextField($form, 'username', array('class'=>'beta-text', 'tabindex'=>2));?>
            <?php if ($form->hasErrors('username')):?><span class="beta-help-inline"><?php echo $form->getError('username');?></span><?php endif;?>
            <p class="suggestion"><?php echo t('username_tip');?></p>
        </div>
        <div class="clear"></div>
    </div>
    <div class="beta-control-group <?php echo $form->hasErrors('password') ? 'error' : '';?>">
        <label class="beta-control-label"><?php echo t('password');?></label>
        <div class="beta-controls">
            <?php echo CHtml::activePasswordField($form, 'password', array('class'=>'beta-text', 'tabindex'=>3));?>
            <?php if ($form->hasErrors('password')):?><span class="beta-help-inline"><?php echo $form->getError('password');?></span><?php endif;?>
        </div>
        <div class="clear"></div>
    </div>
    <div class="beta-control-group <?php echo $form->hasErrors('captcha') ? 'error' : '';?>">
        <label class="beta-control-label"><?php echo t('captcha');?></label>
        <div class="beta-controls">
            <?php echo CHtml::activeTextField($form, 'captcha', array('class'=>'beta-captcha beta-text', 'tabindex'=>4));?>
            <?php $this->widget('BetaCaptcha');?>
            <?php if ($form->hasErrors('captcha')):?><span class="beta-help-inline"><?php echo $form->getError('captcha');?></span><?php endif;?>
        </div>
        <div class="clear"></div>
    </div>
    <div class="beta-control-group <?php echo $form->hasErrors('agreement') ? 'error' : '';?>">
        <label class="beta-control-label">&nbsp;</label>
        <div class="beta-controls beta-agreement">
            <?php echo CHtml::activeCheckBox($form, 'agreement', array('id'=>'agreement', 'tabindex'=>5));?><label for="agreement"><?php echo t('agreement');?></label>
            <?php if ($form->hasErrors('agreement')):?><span class="beta-help-inline"><?php echo $form->getError('agreement');?></span><?php endif;?>
        </div>
        <div class="clear"></div>
    </div>
    <div class="action-buttons">
        <?php echo CHtml::submitButton(t('user_signup'), array('class'=>'beta-btn btn-primary', 'tabindex'=>6));?>
    </div>
    <?php echo chtml::endForm();?>
</div>
<div class="beta-sidebar">
    <p class="quick-login-signup"><?php echo t('quick_login_link');?></p>
</div>
<br class="clear" />

