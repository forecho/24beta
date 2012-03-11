<?php if (user()->hasFlash('user_create_result')):?>
<div class="alert alert-success fade in">
    <a href="javascript:void(0);" data-dismiss="alert" class="close">&times;</a>
    <?php echo user()->getFlash('user_create_result');?>
</div>
<?php endif;?>

<?php echo CHtml::form('', 'post', array('class'=>'form-horizontal'));?>
<fieldset>
    <legend><?php echo $this->adminTitle;?></legend>
    <div class="control-group">
        <?php echo CHtml::activeLabel($model, 'email', array('class'=>'control-label'));?>
        <div class="controls">
            <?php echo $model->email;?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::activeLabel($model, 'name', array('class'=>'control-label'));?>
        <div class="controls">
            <?php echo $model->name;?>
        </div>
    </div>
    <div class="control-group <?php if($model->hasErrors('password')) echo 'error';?>">
        <?php echo CHtml::activeLabel($model, 'password', array('class'=>'control-label'));?>
        <div class="controls">
            <?php echo CHtml::activeTextField($model, 'password');?>
            <?php if($model->hasErrors('password')):?><p class="help-block"><?php echo $model->getError('password');?></p><?php endif;?>
        </div>
    </div>
    <div class="form-actions">
        <input type="submit" value="<?php echo t('submit', 'admin');?>" class="btn btn-primary" />
    </div>
</fieldset>
<?php echo CHtml::endForm();?>