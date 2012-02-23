<?php echo CHtml::form(url('admin/tag/search'), 'get', array('class'=>'form-horizontal'));?>
<fieldset>
    <legend><?php echo t('tag_search', 'admin')?></legend>
    <div class="control-group">
        <label class="control-label"><?php echo t('keyword', 'admin');?></label>
        <div class="controls">
            <?php echo CHtml::textField('keyword', $_GET['keyword']);?>
            <span class="help-inline"><label class="checkbox"><?php echo CHtml::checkBox('fuzzy', $_GET['fuzzy']);?><?php echo t('fuzzy_search', 'admin')?></label></span>
        </div>
    </div>
    <div class="form-actions">
        <input type="submit" value="<?php echo t('search', 'admin');?>" class="btn btn-primary" />
    </div>
</fieldset>
<?php echo CHtml::endForm();?>


<?php if ($tags) $this->renderPartial('list', array('models'=>$tags, 'pages'=>$pages));?>