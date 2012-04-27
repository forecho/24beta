<h3><?php echo user()->getFlash('table_caption', t('special_list_table', 'admin'));?></h3>

<table class="table table-striped table-bordered beta-list-table">
    <thead>
        <tr>
            <th class="span1 align-center"><?php echo $sort->link('id');?></th>
            <th class="span3"><?php echo $sort->link('name');?></th>
            <th class="span3"><?php echo $sort->link('token');?></th>
            <th class="span1 align-center"><?php echo $sort->link('state');?></th>
            <th><a class="label label-important" href="<?php echo url('admin/special/create');?>"><?php echo t('create_special', 'admin');?></a></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($models as $model):?>
        <tr>
            <td class="align-center"><?php echo $model->id;?></td>
            <td><?php echo $model->nameLink;?></td>
            <td><?php echo $model->token;?></td>
            <td class="align-center"><?php echo $model->stateLink;?></td>
            <td>
                <?php echo $model->editLink;?>
                <?php echo $model->deleteLink;?>
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
	var deleteConfirmText = '<?php echo t('delete_confirm', 'admin');?>';
	$(document).on('click', '.row-state', BetaAdmin.ajaxSetBooleanColumn);
});
</script>