<h3><?php echo $this->adminTitle;?></h3>
<table class="table table-striped table-bordered beta-config-table">
    <thead>
        <tr>
            <th class="span1 align-center">ID</th>
            <th class="span3"><?php echo t('filter_keyword');?></th>
            <th class="span3"><?php echo t('filter_replace');?></th>
            <th><a href="<?php echo url('admin/filterkeyword/create');?>" class="label label-important"><?php echo t('create_filter_keyword', 'admin');?></a></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($models as $model):?>
        <tr>
            <td class="align-center">
                <input type="hidden" name="FilterKeyword[<?php echo $model['id'];?>]" value="<?php echo $model['id'];?>" />
                <?php echo $model['id'];?>
            </td>
            <td><input type="text" name="FilterKeyword[<?php echo $model['keyword'];?>]" value="<?php echo h($model['keyword']);?>" /></td>
            <td><input type="text" name="FilterKeyword[<?php echo $model['replace'];?>]" value="<?php echo h($model['replace']);?>" /></td>
            <td>
                <a href="javascript:void(0);" class="update-keyword">更新</a>
            </td>
        </tr>
        <?php endforeach;?>
    </tbody>
</table>
<form action="" method="post" class="form-horizontal">
<fieldset>
    <div class="form-actions">
        <a href="<?php echo url('admin/filterkeyword/create');?>" class="btn"><?php echo t('create_filter_keyword', 'admin');?></a>
    </div>
</fieldset>
</form>

<script type="text/javascript">
$(function(){
	
});
</script>