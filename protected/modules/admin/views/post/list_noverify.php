<h3><?php echo user()->getFlash('table_caption', t('noverify_post_list_table', 'admin'));?></h3>
<div class="btn-toolbar">
    <button class="btn btn-small" id="select-all"><?php echo t('select_all', 'admin');?></button>
    <button class="btn btn-small" id="reverse-select"><?php echo t('reverse_select', 'admin');?></button>
    <button class="btn btn-small btn-primary" id="batch-verify" data-src="<?php echo url('admin/comment/multiVerify');?>"><?php echo t('set_batch_verify', 'admin');?></button>
    <button class="btn btn-small btn-primary" id="batch-reject" data-src="<?php echo url('admin/comment/multiReject');?>"><?php echo t('set_batch_reject', 'admin');?></button>
    <button class="btn btn-small btn-danger" id="beta-delete-multi-comment" data-src="<?php echo url('admin/comment/multiDelete');?>"><?php echo t('delete', 'admin');?></button>
</div>
<table class="table table-striped table-bordered beta-list-table">
    <thead>
        <tr>
            <th class="item-checkbox align-center">#</th>
            <th class="span1 align-center"><?php echo $sort->link('id');?></th>
            <th class="span7"><?php echo $sort->link('title');?></th>
            <th class="span2 align-center"><?php echo $sort->link('create_time');?></th>
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
            <td>
                <?php echo $model->editUrl;?>
                <?php echo $model->verifyUrl;?>
                <?php echo $model->deleteUrl;?>
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
	$(document).on('click', '.set-verify, .set-hottest, .set-recommend, .set-delete', function(event){
		event.preventDefault();
		var tthis = $(this);
		var jqXhr = $.ajax({
		    url: $(this).attr('href'),
		    dataType: 'jsonp',
		    type: 'post',
		    cache: false,
		    beforeSend: function(){}
		});
		jqXhr.done(function(data){
			if (data.errno == 0)
				if (tthis.hasClass('set-delete'))
					tthis.parents('tr').fadeOut('fast', function(){$(this).remove();});
				else
				    tthis.text(data.label);
			else
				alert('error');
		});
		jqXhr.fail(function(){
			alert('fail');
		});
	});
});
</script>