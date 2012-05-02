<h3><?php echo $this->adminTitle;?></h3>
<div class="btn-toolbar">
    <a href="<?php echo url('admin/keyword/create');?>" class="btn btn-small"><?php echo t('create_filter_keyword', 'admin');?></a>
    <a class="btn btn-small" href=''><?php echo t('reload_data', 'admin');?></a>
</div>
<table class="table table-striped table-bordered beta-config-table">
    <thead>
        <tr>
            <th class="span1 align-center">ID</th>
            <th class="span3"><?php echo t('filter_keyword');?></th>
            <th class="span3"><?php echo t('filter_replace');?></th>
            <th><a href="<?php echo url('admin/keyword/create');?>" class="label label-important"><?php echo t('create_filter_keyword', 'admin');?></a></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($rows as $row):?>
        <tr data-url="<?php echo url('admin/keyword/edit');?>">
            <td class="align-center">
                <input type="hidden" name="kwid" value="<?php echo $row['id'];?>" />
                <?php echo $row['id'];?>
            </td>
            <td><input type="text" name="keyword" value="<?php echo h($row['keyword']);?>" /></td>
            <td><input type="text" name="replace" value="<?php echo h($row['replace']);?>" /></td>
            <td>
                <button data-toggle="button" data-loading-text="<?php echo t('updating', 'admin');?>" data-error-text="<?php echo t('update_error', 'admin')?>" data-complete-text="<?php echo t('update_complete', 'admin');?>" class="update-keyword btn btn-mini"><?php echo t('update', 'admin');?></button>
            </td>
        </tr>
        <?php endforeach;?>
    </tbody>
</table>
<?php if ($pages):?>
<div class="beta-pages"><?php $this->widget('CLinkPager', array('pages'=>$pages, 'htmlOptions'=>array('class'=>'pagination')));?></div>
<?php endif;?>

<script type="text/javascript">
$(function(){
	$(document).on('click', '.update-keyword', BetaAdmin.updateFilterKeywordRow);
});
</script>