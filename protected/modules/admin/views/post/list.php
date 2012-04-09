<h3><?php echo user()->getFlash('table_caption', t('post_list_table', 'admin'));?></h3>
<div class="btn-toolbar">
    <button class="btn btn-small" id="select-all"><?php echo t('select_all', 'admin');?></button>
    <button class="btn btn-small" id="reverse-select"><?php echo t('reverse_select', 'admin');?></button>
    <button class="btn btn-small btn-primary" id="batch-verify"><?php echo t('setrecommend', 'admin');?></button>
    <button class="btn btn-small btn-primary" id="batch-reject"><?php echo t('sethottest', 'admin');?></button>
    <button class="btn btn-small btn-danger" id="batch-delete"><?php echo t('delete', 'admin');?></button>
</div>
<table class="table table-striped table-bordered beta-list-table">
    <thead>
        <tr>
            <th class="item-checkbox align-center">#</th>
            <th class="span1 align-center"><?php echo $sort->link('id');?></th>
            <th class="span7"><?php echo $sort->link('title');?></th>
            <th class="span2 align-center"><?php echo $sort->link('create_time');?></th>
            <th class="span1 align-center">#</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($models as $model):?>
        <tr>
            <td class="item-checkbox"><input type="checkbox" name="itemid[]" value="<?php echo $model->id;?>" /></td>
            <td class="align-center"><?php echo $model->id;?></td>
            <td><?php echo $model->getAdminTitleLink();?></td>
            <td class="align-center"><?php echo $model->createTime;?></td>
            <td class="align-center"><?php echo $model->editUrl;?></td>
            <td>
                <div class="dropdown">
                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown"><?php echo t('operation', 'admin');?><b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><?php echo $model->commentUrl;?></li>
                        <li><?php echo $model->homeshowUrl;?></li>
                        <li><?php echo $model->recommendUrl;?></li>
                        <li><?php echo $model->hottestUrl;?></li>
                        <li><?php echo $model->verifyUrl;?></li>
                        <li><?php echo $model->deleteUrl;?></li>
                    </ul>
                </div>
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
	$(document).on('click', '.set-verify, .set-hottest, .set-recommend', BetaAdmin.ajaxSetPostBoolColumn);
	$(document).on('click', '.set-delete', {onfirmText:deleteConfirmText}, BetaAdmin.deletePost);
});
</script>