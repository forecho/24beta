<div class="beta-content beta-post-show beta-radius3px">
    <?php echo CHtml::form('',  'post', array('class'=>'post-form', 'id'=>'post-form'));?>
    <div class="clearfix post-clearfix <?php if ($form->hasErrors('title')) echo 'error';?>">
        <label><?php echo t('post_title');?></label>
        <div class="input post-input">
            <?php echo CHtml::activeTextField($form, 'title', array('class'=>'span7', 'id'=>'post-title'));?>
            <span class="help-block"><?php echo $form->getError('title');?></span>
        </div>
    </div>
    <div class="clearfix post-clearfix <?php if ($form->hasErrors('source')) echo 'error';?>">
        <label><?php echo t('post_source');?></label>
        <div class="input post-input">
            <?php echo CHtml::activeTextField($form, 'source', array('class'=>'span6'));?>
            <span class="help-block"><?php echo $form->getError('source');?></span>
        </div>
    </div>
    <div class="clearfix post-clearfix <?php if ($form->hasErrors('contributor')) echo 'error';?>">
        <label><?php echo t('post_contributor');?></label>
        <div class="input post-input">
            <?php echo CHtml::activeTextField($form, 'contributor', array('class'=>'span3'));?>
            <span class="help-block"><?php echo $form->getError('contributor');?></span>
        </div>
    </div>
    <div class="clearfix post-clearfix <?php if ($form->hasErrors('contributor_site')) echo 'error';?>">
        <label><?php echo t('post_contributor_site');?></label>
        <div class="input post-input">
            <?php echo CHtml::activeTextField($form, 'contributor_site', array('class'=>'span6', 'id'=>'post-site'));?>
            <span class="help-block"><?php echo $form->getError('contributor_site');?></span>
        </div>
    </div>
    <div class="clearfix post-clearfix <?php if ($form->hasErrors('contributor_email')) echo 'error';?>">
        <label><?php echo t('post_contributor_email');?></label>
        <div class="input post-input">
            <?php echo CHtml::activeTextField($form, 'contributor_email', array('class'=>'span6', 'id'=>'post-email'));?>
            <span class="help-block"><?php echo $form->getError('contributor_email');?></span>
        </div>
    </div>
    <div class="clearfix stacked post-clearfix <?php if ($form->hasErrors('summary')) echo 'error';?>">
        <label><?php echo t('summary');?>&nbsp;<span class="help-inline"><?php echo $form->getError('summary');?></span></label>
        <div class="input post-input">
            <?php echo CHtml::activeTextArea($form, 'summary', array('class'=>'span10', 'id'=>'beta-summary'));?>
        </div>
    </div>
    <div class="clearfix stacked  post-clearfix <?php if ($form->hasErrors('content')) echo 'error';?>">
        <label><?php echo t('content');?>&nbsp;<span class="help-inline"><?php echo $form->getError('content');?></span></label>
        <div class="input post-input">
            <?php echo CHtml::activeTextArea($form, 'content', array('class'=>'span10', 'id'=>'beta-content'));?>
        </div>
    </div>
    <div class="clearfix post-clearfix captcha-clearfix <?php echo $captchaClass?>">
        <label><?php echo t('captcha');?></label>
        <div class="input post-input">
            <?php echo CHtml::activeTextField($form, 'captcha', array('class'=>'beta-captcha input-mini'));?>
            <?php echo $captchaWidget;?>
            <span class="help-inline"><?php echo $form->getError('captcha');?></span>
        </div>
    </div>
    <div class="actions">
        <?php echo CHtml::submitButton(t('submit'), array('class'=>'btn primary'));?>
        <?php echo CHtml::resetButton(t('reset'), array('class'=>'btn'));?>
    </div>
    <?php echo CHtml::endForm();?>
</div>

<div class="beta-sidebar">
    <div class="beta-sidebar-block beta-small beta-radius3px">
        <h2>投稿必读</h2>
        <ul class="content">
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
    	var betaSummary = K.create('#beta-summary', KEConfig.mini);
    	var betaContent = K.create('#beta-content', KEConfig.common);
    	$('#post-form').on('submit', {content:betaContent}, BetaPost.create);
    });
});
</script>

