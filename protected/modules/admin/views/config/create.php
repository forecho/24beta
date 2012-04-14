<?php if (user()->hasFlash('save_custom_param_result')):?>
<div class="alert alert-success fade in">
    <a href="javascript:void(0);" data-dismiss="alert" class="close">&times;</a>
    <?php echo user()->getFlash('save_custom_param_result');?>
</div>
<?php endif;?>

<?php echo CHtml::form('', 'post', array('class'=>'form-horizontal', 'enctype'=>'multipart/form-data'));?>
<fieldset>
    <legend><?php echo $this->adminTitle;?></legend>
    <div class="control-group <?php if($model->hasErrors('name')) echo 'error';?>">
        <?php echo CHtml::activeLabel($model, 'name', array('class'=>'control-label'));?>
        <div class="controls">
            <?php echo CHtml::activeTextField($model, 'name', array('class'=>'span4'));?>
            <?php if($model->hasErrors('name')):?><p class="help-block"><?php echo $model->getError('name');?></p><?php endif;?>
        </div>
    </div>
    <div class="control-group <?php if($model->hasErrors('config_name')) echo 'error';?>">
        <?php echo CHtml::activeLabel($model, 'config_name', array('class'=>'control-label'));?>
        <div class="controls">
            <?php echo CHtml::activeTextField($model, 'config_name', array('class'=>'span4'));?>
            <?php if($model->hasErrors('config_name')):?><p class="help-block"><?php echo $model->getError('config_name');?></p><?php endif;?>
        </div>
    </div>
    <div class="control-group <?php if($model->hasErrors('config_value')) echo 'error';?>">
        <?php echo CHtml::activeLabel($model, 'config_value', array('class'=>'control-label'));?>
        <div class="controls">
            <?php echo CHtml::activeTextArea($model, 'config_value', array('class'=>'span6'));?>
            <?php if($model->hasErrors('config_value')):?><p class="help-block"><?php echo $model->getError('config_value');?></p><?php endif;?>
        </div>
    </div>
    <div class="control-group <?php if($model->hasErrors('desc')) echo 'error';?>">
        <?php echo CHtml::activeLabel($model, 'desc', array('class'=>'control-label'));?>
        <div class="controls">
            <?php echo CHtml::activeTextArea($model, 'desc', array('class'=>'span6'));?>
            <?php if($model->hasErrors('desc')):?><p class="help-block"><?php echo $model->getError('desc');?></p><?php endif;?>
        </div>
    </div>
    <div class="control-group warning">
        <label class="control-label">&nbsp;</label>
        <div class="controls">
            <p class="help-block"><?php echo t('create_custom_param_value_tip', 'admin')?></p>
            <p class="help-block"><?php echo t('create_custom_param_name_tip', 'admin')?></p>
        </div>
    </div>
    <div class="form-actions">
        <input type="submit" value="<?php echo t('submit', 'admin');?>" class="btn btn-primary" />
    </div>
</fieldset>
<?php echo CHtml::endForm();?>