<?php if (user()->hasFlash('save_topic_result')):?>
<div class="alert alert-success fade in">
    <a href="javascript:void(0);" data-dismiss="alert" class="close">&times;</a>
    <?php echo user()->getFlash('save_topic_result');?>
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
    <div class="control-group <?php if($model->hasErrors('parent_id')) echo 'error';?>">
        <?php echo CHtml::activeLabel($model, 'parent_id', array('class'=>'control-label'));?>
        <div class="controls">
            <?php echo CHtml::activeDropDownList($model, 'parent_id', $parents, array('empty'=>$empty));?>
            <span class="help-inline"><?php echo t('create_root_topic', 'admin');?></span>
            <?php if($model->hasErrors('parent_id')):?><p class="help-block"><?php echo $model->getError('parent_id');?></p><?php endif;?>
        </div>
    </div>
    <div class="control-group <?php if($model->hasErrors('icon')) echo 'error';?>">
        <?php echo CHtml::activeLabel($model, 'icon', array('class'=>'control-label'));?>
        <div class="controls">
            <?php echo CHtml::activeFileField($model, 'icon');?>
            <?php if($model->hasErrors('icon')):?><p class="help-block"><?php echo $model->getError('icon');?></p><?php endif;?>
        </div>
    </div>
    <?php if ($model->icon):?>
    <div class="control-group">
        <div class="controls">
            <p><?php echo $model->iconHtml;?></p>
        </div>
    </div>
    <?php endif;?>
    <div class="control-group <?php if($model->hasErrors('orderid')) echo 'error';?>">
        <?php echo CHtml::activeLabel($model, 'orderid', array('class'=>'control-label'));?>
        <div class="controls">
            <?php echo CHtml::activeTextField($model, 'orderid', array('class'=>'input-mini'));?>
            <?php if($model->hasErrors('orderid')):?><p class="help-block"><?php echo $model->getError('orderid');?></p><?php endif;?>
        </div>
    </div>
    <div class="form-actions">
        <input type="submit" value="<?php echo t('search', 'admin');?>" class="btn btn-primary" />
    </div>
</fieldset>
<?php echo CHtml::endForm();?>

<?php echo CHtml::errorSummary($model);?>