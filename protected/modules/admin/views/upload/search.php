<?php echo CHtml::form(url('admin/upload/search'), 'get', array('class'=>'form-horizontal'));?>
<fieldset>
    <legend><?php echo t('search_upload_file', 'admin')?></legend>
    <div class="control-group">
        <?php echo CHtml::activeLabel($form, 'postid', array('class'=>'control-label'));?>
        <div class="controls">
            <?php echo CHtml::activeTextField($form, 'postid', array('class'=>'input-small'));?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::activeLabel($form, 'userid', array('class'=>'control-label'));?>
        <div class="controls">
            <?php echo CHtml::activeTextField($form, 'userid', array('class'=>'input-small'));?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::activeLabel($form, 'fileType', array('class'=>'control-label'));?>
        <div class="controls">
            <?php echo CHtml::activeDropDownList($form, 'fileType', $fileTypes, array('empty'=>t('please_select_file_type', 'admin')));?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::activeLabel($form, 'keyword', array('class'=>'control-label'));?>
        <div class="controls">
            <?php echo CHtml::activeTextField($form, 'keyword', array('class'=>'span5'));?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::activeLabel($form, 'fileUrl', array('class'=>'control-label'));?>
        <div class="controls">
            <?php echo CHtml::activeTextField($form, 'fileUrl', array('class'=>'span5'));?>
        </div>
    </div>
    <div class="form-actions">
        <input type="submit" value="<?php echo t('search', 'admin');?>" class="btn btn-primary" />
        <a class="btn" href="<?php echo url('admin/upload/list');?>"><?php echo t('return_list_page', 'admin');?></a>
    </div>
</fieldset>
<?php echo CHtml::endForm();?>

<?php if ($data !== null) $this->renderPartial('list', $data);?>