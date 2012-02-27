<?php if (user()->hasFlash('save_category_result')):?>
<div class="alert alert-success fade in">
    <a href="javascript:void(0);" data-dismiss="alert" class="close">&times;</a>
    <?php echo user()->getFlash('save_category_result');?>
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
            <span class="help-inline"><?php echo t('create_root_category', 'admin');?></span>
            <?php if($model->hasErrors('parent_id')):?><p class="help-block"><?php echo $model->getError('parent_id');?></p><?php endif;?>
        </div>
    </div>
    <div class="control-group <?php if($model->hasErrors('orderid')) echo 'error';?>">
        <?php echo CHtml::activeLabel($model, 'orderid', array('class'=>'control-label'));?>
        <div class="controls">
            <?php echo CHtml::activeTextField($model, 'orderid', array('class'=>'input-mini'));?>
            <?php if($model->hasErrors('orderid')):?><p class="help-block"><?php echo $model->getError('orderid');?></p><?php endif;?>
        </div>
    </div>
    <div class="form-actions">
        <input type="submit" value="<?php echo t('submit', 'admin');?>" class="btn btn-primary" />
    </div>
</fieldset>
<?php echo CHtml::endForm();?>