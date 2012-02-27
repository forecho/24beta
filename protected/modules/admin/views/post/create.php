<?php if (user()->hasFlash('save_post_result')):?>
<div class="alert alert-success fade in">
    <a href="javascript:void(0);" data-dismiss="alert" class="close">&times;</a>
    <?php echo user()->getFlash('save_post_result');?>
</div>
<?php endif;?>

<?php echo CHtml::form('',  'post', array('class'=>'form-horizontal post-form'));?>
<fieldset>
    <legend>发布文章</legend>
    <div class="control-group bottom10px <?php if ($model->hasErrors('title')) echo 'error';?>">
        <label class="control-label"><?php echo t('post_title');?></label>
        <div class="controls">
            <?php echo CHtml::activeTextField($model, 'title', array('class'=>'span6', 'id'=>'post-title'));?>
            <?php if ($model->hasErrors('title')):?><p class="help-block"><?php echo $model->getError('title');?></p><?php endif;?>
        </div>
    </div>
    <div class="control-group bottom10px <?php if ($model->hasErrors('source')) echo 'error';?>">
        <label class="control-label"><?php echo t('post_source');?></label>
        <div class="controls">
            <?php echo CHtml::activeTextField($model, 'source', array('class'=>'span6'));?>
            <?php if ($model->hasErrors('source')):?><p class="help-block"><?php echo $model->getError('source');?></p><?php endif;?>
        </div>
    </div>
    <div class="control-group bottom10px">
        <div class="controls">
            <?php echo CHtml::submitButton(t('submit', 'admin'), array('class'=>'btn btn-primary'));?>
            <?php echo CHtml::resetButton(t('reset', 'admin'), array('class'=>'btn'));?>
        </div>
    </div>
    <div class="control-group bottom10px <?php if ($model->hasErrors('summary')) echo 'error';?>">
        <label class="control-label"><?php echo t('summary');?></label>
        <div class="controls">
            <?php echo CHtml::activeTextArea($model, 'summary', array('id'=>'summary'));?>
            <?php if ($model->hasErrors('summary')):?><p class="help-block"><?php echo $model->getError('summary');?></p><?php endif;?>
        </div>
    </div>
    <div class="control-group bottom10px <?php if ($model->hasErrors('content')) echo 'error';?>">
        <label class="control-label"><?php echo t('content');?></label>
        <div class="controls">
            <?php echo CHtml::activeTextArea($model, 'content', array('id'=>'content'));?>
            <?php if ($model->hasErrors('content')):?><p class="help-block"><?php echo $model->getError('content');?></p><?php endif;?>
        </div>
    </div>
    <div class="control-group bottom10px">
        <div class="controls">
            <?php echo CHtml::submitButton(t('submit', 'admin'), array('class'=>'btn btn-primary'));?>
            <?php echo CHtml::resetButton(t('reset', 'admin'), array('class'=>'btn'));?>
        </div>
    </div>
    <div class="control-group bottom10px <?php if ($model->hasErrors('tags')) echo 'error';?>">
        <label class="control-label"><?php echo t('tags');?></label>
        <div class="controls">
            <?php echo CHtml::activeTextField($model, 'tags', array('class'=>'span4'));?>
            <span class="help-inline"><?php echo t('tags_rules', 'admin');?></span>
            <?php if ($model->hasErrors('tags')):?><p class="help-block"><?php echo $model->getError('tags');?></p><?php endif;?>
        </div>
    </div>
    <div class="control-group bottom10px">
        <label class="control-label"><?php echo t('options', 'admin');?></label>
        <div class="controls">
            <label class="checkbox inline">
                <?php echo CHtml::activeCheckBox($model, 'state');?><?php echo t('state_show', 'admin');?>
            </label>
            <label class="checkbox inline">
                <?php echo CHtml::activeCheckBox($model, 'istop');?><?php echo t('settop', 'admin');?>
            </label>
            <label class="checkbox inline">
                <?php echo CHtml::activeCheckBox($model, 'disable_comment');?><?php echo t('disable_comment');?>
            </label>
        </div>
    </div>
    <div class="control-group bottom10px <?php if ($model->hasErrors('thumbnail')) echo 'error';?>">
        <label class="control-label"><?php echo t('thumbnail');?></label>
        <div class="controls">
            <?php echo CHtml::activeTextField($model, 'thumbnail', array('class'=>'span6'));?>
            <?php if ($model->hasErrors('thumbnail')):?><p class="help-block"><?php echo $model->getError('thumbnail');?></p><?php endif;?>
        </div>
    </div>
    <div class="control-group bottom10px <?php if ($model->hasErrors('contributor')) echo 'error';?>">
        <label class="control-label"><?php echo t('post_contributor');?></label>
        <div class="controls">
            <?php echo CHtml::activeTextField($model, 'contributor', array('class'=>'text'));?>
            <?php if ($model->hasErrors('contributor')):?><p class="help-block"><?php echo $model->getError('contributor');?></p><?php endif;?>
        </div>
    </div>
    <div class="control-group bottom10px <?php if ($model->hasErrors('contributor_site')) echo 'error';?>">
        <label class="control-label"><?php echo t('post_contributor_site');?></label>
        <div class="controls">
            <?php echo CHtml::activeTextField($model, 'contributor_site', array('class'=>'span6'));?>
            <?php if ($model->hasErrors('contributor_site')):?><p class="help-block"><?php echo $model->getError('contributor_site');?></p><?php endif;?>
        </div>
    </div>
    <div class="control-group bottom10px <?php if ($model->hasErrors('contributor_email')) echo 'error';?>">
        <label class="control-label"><?php echo t('post_contributor_email');?></label>
        <div class="controls">
            <?php echo CHtml::activeTextField($model, 'contributor_email', array('class'=>'span6'));?>
            <?php if ($model->hasErrors('contributor_email')):?><p class="help-block"><?php echo $model->getError('contributor_email');?></p><?php endif;?>
        </div>
    </div>
    <div class="form-actions">
        <?php echo CHtml::submitButton(t('submit', 'admin'), array('class'=>'btn btn-primary'));?>
        <?php echo CHtml::resetButton(t('reset', 'admin'), array('class'=>'btn'));?>
    </div>
</fieldset>
<?php echo CHtml::endForm();?>

<?php cs()->registerScriptFile(sbu('libs/kindeditor/kindeditor-min.js'), CClientScript::POS_END);?>
<?php cs()->registerScriptFile(sbu('libs/kindeditor/config.js'), CClientScript::POS_END);?>

<script type="text/javascript">
$(function(){
	$(':text:first').focus();
    KindEditor.ready(function(K) {
        var cssurl = '<?php echo tbu('styles/beta-all.css');?>';
        KEConfig.adminmini.cssPath = [cssurl];
        KEConfig.adminfull.cssPath = [cssurl];
    	var betaSummary = K.create('#summary', KEConfig.adminmini);
    	var betaContent = K.create('#content', KEConfig.adminfull);
    });
});
</script>

