<?php echo CHtml::form(url('admin/post/search'), 'get', array('class'=>'form-horizontal'));?>
<fieldset>
    <legend><?php echo t('post_search', 'admin')?></legend>
    <div class="control-group">
        <?php echo CHtml::activeLabel($form, 'postid', array('class'=>'control-label'));?>
        <div class="controls">
            <?php echo CHtml::activeTextField($form, 'postid', array('class'=>'input-mini'));?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::activeLabel($form, 'keyword', array('class'=>'control-label'));?>
        <div class="controls">
            <?php echo CHtml::activeTextField($form, 'keyword');?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::activeLabel($form, 'author', array('class'=>'control-label'));?>
        <div class="controls">
            <?php echo CHtml::activeTextField($form, 'author');?>
        </div>
    </div>
    <div class="form-actions">
        <input type="submit" value="<?php echo t('search', 'admin');?>" class="btn btn-primary" />
    </div>
</fieldset>
<?php echo CHtml::endForm();?>

<?php if ($data !== null) $this->renderPartial('list', $data);?>