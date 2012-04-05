<?php echo CHtml::form(url('admin/comment/search'), 'get', array('class'=>'form-horizontal'));?>
<fieldset>
    <legend><?php echo t('comment_search', 'admin')?></legend>
    <div class="control-group">
        <?php echo CHtml::activeLabel($form, 'comment_id', array('class'=>'control-label'));?>
        <div class="controls">
            <?php echo CHtml::activeTextField($form, 'comment_id', array('class'=>'input-small'));?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::activeLabel($form, 'post_id', array('class'=>'control-label'));?>
        <div class="controls">
            <?php echo CHtml::activeTextField($form, 'post_id', array('class'=>'input-small'));?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::activeLabel($form, 'keyword', array('class'=>'control-label'));?>
        <div class="controls">
            <?php echo CHtml::activeTextField($form, 'keyword');?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::activeLabel($form, 'user_id', array('class'=>'control-label'));?>
        <div class="controls">
            <?php echo CHtml::activeTextField($form, 'user_id');?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::activeLabel($form, 'user_name', array('class'=>'control-label'));?>
        <div class="controls">
            <?php echo CHtml::activeTextField($form, 'user_name');?>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label"><?php echo t('comment_create_time', 'admin');?></label>
        <div class="controls">
            <?php echo CHtml::activeTextField($form, 'start_create_time', array('class'=>'span2'));?>&nbsp;-&nbsp;
            <?php echo CHtml::activeTextField($form, 'end_create_time', array('class'=>'span2'));?>
        </div>
    </div>
    <div class="form-actions">
        <input type="submit" value="<?php echo t('search', 'admin');?>" class="btn btn-primary" />
    </div>
</fieldset>
<?php echo CHtml::endForm();?>

<?php if ($data !== null) $this->renderPartial('list', $data);?>