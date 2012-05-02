<?php if (user()->hasFlash('save_filter_keyword_result')):?>
<div class="alert alert-success fade in">
    <a href="javascript:void(0);" data-dismiss="alert" class="close">&times;</a>
    <?php echo user()->getFlash('save_filter_keyword_result');?>
</div>
<?php endif;?>

<?php if ($errors):?>
<div class="alert alert-error">
    <div class="alert-heading"><?php echo t('occurred_following_errors', 'admin');?></div>
    <ul>
    <?php foreach ((array)$errors as $error):?>
        <li><?php echo $error['keyword'];?>&nbsp;&nbsp;-&nbsp;&nbsp;<?php echo $error['message']?></li>
    <?php endforeach;?>
    </ul>
</div>
<?php endif;?>

<form action='' method="post" class="form-horizontal">
    <fieldset>
        <legend><?php echo $this->adminTitle;?></legend>
        <div class="control-group">
            <div class="controls">
                <textarea id="kwcontent" name="kwcontent"><?php echo $_POST['kwcontent']?></textarea>
                <p class="help-block"><?php echo t('kwcontent_format_tip', 'admin');?></p>
            </div>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-small btn-primary"><?php echo t('submit', 'admin');?></button>
            <a class="btn btn-small" href="<?php echo url('admin/keyword/list');?>"><?php echo t('return_list_page', 'admin');?></a>
        </div>
    </fieldset>
</form>

<div class="alert alert-block alert-info">
    <a href="javascript:void(0);" data-dismiss="alert" class="close">&times;</a>
    <?php echo t('filter_keyword_alert', 'admin')?>
</div>