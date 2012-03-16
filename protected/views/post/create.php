<div class="beta-content beta-post-show beta-radius3px">
    <?php echo CHtml::form('',  'post', array('class'=>'beta-form-horizontal beta-post-form', 'id'=>'post-form'));?>
    <div class="beta-control-group <?php if ($form->hasErrors('title')) echo 'error';?>">
        <label class="beta-control-label"><?php echo t('post_title');?></label>
        <div class="beta-controls">
            <?php echo CHtml::activeTextField($form, 'title', array('class'=>'beta-text', 'id'=>'post-title'));?>
            <p class="beta-help-block"><?php echo $form->getError('title');?></p>
        </div>
        <div class="clear"></div>
    </div>
    <div class="beta-control-group <?php if ($form->hasErrors('source')) echo 'error';?>">
        <label class="beta-control-label"><?php echo t('post_source');?></label>
        <div class="beta-controls">
            <?php echo CHtml::activeTextField($form, 'source', array('class'=>'beta-text'));?>
            <p class="beta-help-block"><?php echo $form->getError('source');?></p>
        </div>
        <div class="clear"></div>
    </div>
    <div class="beta-control-group <?php if ($form->hasErrors('contributor')) echo 'error';?>">
        <label class="beta-control-label"><?php echo t('post_contributor');?></label>
        <div class="beta-controls">
            <?php echo CHtml::activeTextField($form, 'contributor', array('class'=>'beta-text'));?>
            <p class="beta-help-block"><?php echo $form->getError('contributor');?></p>
        </div>
        <div class="clear"></div>
    </div>
    <div class="beta-control-group <?php if ($form->hasErrors('contributor_site')) echo 'error';?>">
        <label class="beta-control-label"><?php echo t('post_contributor_site');?></label>
        <div class="beta-controls">
            <?php echo CHtml::activeTextField($form, 'contributor_site', array('class'=>'beta-text', 'id'=>'post-site'));?>
            <p class="beta-help-block"><?php echo $form->getError('contributor_site');?></p>
        </div>
        <div class="clear"></div>
    </div>
    <div class="beta-control-group <?php if ($form->hasErrors('contributor_email')) echo 'error';?>">
        <label class="beta-control-label"><?php echo t('post_contributor_email');?></label>
        <div class="beta-controls">
            <?php echo CHtml::activeTextField($form, 'contributor_email', array('class'=>'beta-text', 'id'=>'post-email'));?>
            <p class="beta-help-block"><?php echo $form->getError('contributor_email');?></p>
        </div>
        <div class="clear"></div>
    </div>
    <?php if (user()->checkAccess('enterAdminSystem')):?>
    <div class="beta-control-group <?php if ($form->hasErrors('tags')) echo 'error';?>">
        <label class="beta-control-label"><?php echo t('tags');?></label>
        <div class="beta-controls">
            <?php echo CHtml::activeTextField($form, 'tags', array('class'=>'beta-text', 'id'=>'post-tags'));?>
            <p class="beta-help-block"><?php echo $form->getError('tags');?></p>
        </div>
        <div class="clear"></div>
    </div>
    <?php endif;?>
    <div class="beta-control-group stacked <?php if ($form->hasErrors('summary')) echo 'error';?>">
        <label class="beta-control-label"><?php echo t('summary');?>&nbsp;<span class="beta-help-inline"><?php echo $form->getError('summary');?></span></label>
        <div class="beta-controls">
            <?php echo CHtml::activeTextArea($form, 'summary', array('id'=>'beta-summary'));?>
        </div>
        <div class="clear"></div>
    </div>
    <div class="beta-control-group stacked <?php if ($form->hasErrors('content')) echo 'error';?>">
        <label class="beta-control-label"><?php echo t('content');?>&nbsp;<span class="beta-help-inline"><?php echo $form->getError('content');?></span></label>
        <div class="beta-controls">
            <?php echo CHtml::activeTextArea($form, 'content', array('id'=>'beta-content'));?>
        </div>
        <div class="clear"></div>
    </div>
    <?php if (!$form->captchaAllowEmpty()):?>
    <div class="beta-control-group captcha-clearfix <?php echo $captchaClass?>">
        <label class="beta-control-label"><?php echo t('captcha');?></label>
        <div class="beta-controls">
            <?php echo CHtml::activeTextField($form, 'captcha', array('class'=>'beta-captcha beta-text'));?>
            <?php echo $captchaWidget;?>
            <span class="beta-help-inline"><?php echo $form->getError('captcha');?></span>
        </div>
        <div class="clear"></div>
    </div>
    <?php endif;?>
    <div class="beta-form-actions acenter">
        <?php echo CHtml::submitButton(t('submit'), array('class'=>'beta-btn btn-primary'));?>
        <?php echo CHtml::resetButton(t('reset'), array('class'=>'beta-btn'));?>
    </div>
    <?php echo CHtml::endForm();?>
</div>

<div class="beta-sidebar">
    <div class="beta-block beta-small beta-radius3px">
        <h2>投稿必读</h2>
        <ul class="beta-block-content">
            <li>欢迎原创及翻译文章，您的独家报料与独特视角是CB的宝贵财富</li>
            <li>非原创文章必须填写来源</li>
            <li>别忘了署名! 写上您的blog地址,带来意想不到的人气,也可能发现志同道合的CB访客</li>
            <li>编辑也许会对投递进行适当修改, 以适合在本站发表</li>
            <li>请仔细查看：<a class="cred" href="#">新闻投递规范</a></li>
        </ul>
    </div>
</div>
<div class="clear"></div>

<?php cs()->registerScriptFile(sbu('libs/kindeditor/kindeditor-min.js'), CClientScript::POS_END);?>
<?php cs()->registerScriptFile(sbu('libs/kindeditor/config.js'), CClientScript::POS_END);?>

<script type="text/javascript">
$(function(){
	$('#post-title').focus();
    KindEditor.ready(function(K) {
    	var cssurl = '<?php echo tbu('styles/beta-all.css');?>';
    	var imageUploadUrl = '<?php echo aurl('upload/image');?>';
    	KEConfig.mini.cssPath = [cssurl];
    	KEConfig.mini.uploadJson = imageUploadUrl;
        KEConfig.common.cssPath = [cssurl];
        KEConfig.common.uploadJson = imageUploadUrl;
    	var betaSummary = K.create('#beta-summary', KEConfig.mini);
    	var betaContent = K.create('#beta-content', KEConfig.common);
    	$('#post-form').on('submit', {content:betaContent}, BetaPost.create);
    });
});
</script>

