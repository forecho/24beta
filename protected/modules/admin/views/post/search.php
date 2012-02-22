<?php echo CHtml::form('', 'get', array('class'=>'form-horizontal'));?>
<fieldset>
    <legend>文章查询</legend>
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
        <input type="submit" value="查询" class="btn btn-primary" />
    </div>
</fieldset>
<?php echo CHtml::endForm();?>

<?php if ($data !== null) $this->renderPartial('list', $data);?>