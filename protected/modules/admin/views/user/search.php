<?php echo CHtml::form(url('admin/user/search'), 'get', array('class'=>'form-horizontal'));?>
<fieldset>
    <legend><?php echo t('search_user', 'admin')?></legend>
    <div class="control-group">
        <?php echo CHtml::activeLabel($form, 'userid', array('class'=>'control-label'));?>
        <div class="controls">
            <?php echo CHtml::activeTextField($form, 'userid', array('class'=>'input-mini'));?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::activeLabel($form, 'email', array('class'=>'control-label'));?>
        <div class="controls">
            <?php echo CHtml::activeTextField($form, 'email');?>
            <span class="help-inline"><label class="checkbox"><?php echo CHtml::activeCheckBox($form, 'emailFuzzy');?><?php echo t('fuzzy_search', 'admin')?></label></span>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::activeLabel($form, 'name', array('class'=>'control-label'));?>
        <div class="controls">
            <?php echo CHtml::activeTextField($form, 'name');?>
            <span class="help-inline"><label class="checkbox"><?php echo CHtml::activeCheckBox($form, 'nameFuzzy');?><?php echo t('fuzzy_search', 'admin')?></label></span>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::activeLabel($form, 'state', array('class'=>'control-label'));?>
        <div class="controls">
            <?php echo CHtml::activeDropDownList($form, 'state', AdminUser::stateLabels());?>
        </div>
    </div>
    <div class="form-actions">
        <input type="submit" value="<?php echo t('search', 'admin');?>" class="btn btn-primary" />
    </div>
</fieldset>
<?php echo CHtml::endForm();?>

<?php if ($data !== null) $this->renderPartial('list', $data);?>