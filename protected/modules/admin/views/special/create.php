<?php if (user()->hasFlash('save_special_result')):?>
<div class="alert alert-success fade in">
    <a href="javascript:void(0);" data-dismiss="alert" class="close">&times;</a>
    <?php echo user()->getFlash('save_special_result');?>
</div>
<?php endif;?>

<?php echo CHtml::form('', 'post', array('class'=>'form-horizontal', 'enctype'=>'multipart/form-data'));?>
<fieldset>
    <legend><?php echo $this->adminTitle;?></legend>
    <div class="control-group <?php if($model->hasErrors('name')) echo 'error';?>">
        <?php echo CHtml::activeLabel($model, 'name', array('class'=>'control-label'));?>
        <div class="controls">
            <?php echo CHtml::activeTextField($model, 'name');?>
            <?php if($model->hasErrors('name')):?><p class="help-block"><?php echo $model->getError('name');?></p><?php endif;?>
        </div>
    </div>
    <div class="control-group <?php if($model->hasErrors('token')) echo 'error';?>">
        <?php echo CHtml::activeLabel($model, 'token', array('class'=>'control-label'));?>
        <div class="controls">
            <?php echo CHtml::activeTextField($model, 'token');?>
            <?php if($model->hasErrors('token')):?><p class="help-block"><?php echo $model->getError('token');?></p><?php endif;?>
        </div>
    </div>
    <div class="control-group <?php if($model->hasErrors('thumbnail')) echo 'error';?>">
        <?php echo CHtml::activeLabel($model, 'thumbnail', array('class'=>'control-label'));?>
        <div class="controls">
            <?php echo CHtml::activeFileField($model, 'thumbnail');?>
            <?php if($model->hasErrors('thumbnail')):?><p class="help-block"><?php echo $model->getError('thumbnail');?></p><?php endif;?>
        </div>
    </div>
    <?php if ($model->thumbnail):?>
    <div class="control-group">
        <div class="controls">
            <p><?php echo $model->thumbnailHtml;?></p>
        </div>
    </div>
    <?php endif;?>
    <div class="control-group <?php if($model->hasErrors('state')) echo 'error';?>">
        <?php echo CHtml::activeLabel($model, 'state', array('class'=>'control-label'));?>
        <div class="controls">
            <label class="checkbox inline">
                <?php echo CHtml::activeCheckBox($model, 'state');?><?php echo t('special_enabled', 'admin');?>
            </label>
            <?php if($model->hasErrors('state')):?><p class="help-block"><?php echo $model->getError('state');?></p><?php endif;?>
        </div>
    </div>
    <div class="control-group bottom10px <?php if ($model->hasErrors('desc')) echo 'error';?>">
        <label class="control-label"><?php echo t('special_desc');?></label>
        <div class="controls">
            <?php echo CHtml::activeTextArea($model, 'desc', array('id'=>'special-desc'));?>
            <?php if ($model->hasErrors('desc')):?><p class="help-block"><?php echo $model->getError('desc');?></p><?php endif;?>
        </div>
    </div>
    <div class="form-actions">
        <input type="submit" value="<?php echo t('submit', 'admin');?>" class="btn btn-primary" />
        <a class="btn" href="<?php echo url('admin/special/list');?>"><?php echo t('return_list_page', 'admin');?></a>
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
    	var betaSummary = K.create('#special-desc', KEConfig.adminmini);
    });
});
</script>

