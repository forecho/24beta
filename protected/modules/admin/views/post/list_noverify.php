<h3><?php echo user()->getFlash('table_caption', t('noverify_post_list_table', 'admin'));?></h3>
<div class="btn-toolbar">
    <button class="btn btn-small" id="select-all"><?php echo t('select_all', 'admin');?></button>
    <button class="btn btn-small" id="reverse-select"><?php echo t('reverse_select', 'admin');?></button>
    <button class="btn btn-small btn-primary" id="batch-verify" data-src="<?php echo url('admin/post/multiVerify');?>"><?php echo t('set_batch_verify', 'admin');?></button>
    <button class="btn btn-small btn-primary" id="batch-reject" data-src="<?php echo url('admin/post/multiReject');?>"><?php echo t('set_batch_reject', 'admin');?></button>
    <button class="btn btn-small btn-danger" id="batch-delete" data-src="<?php echo url('admin/post/multiDelete');?>"><?php echo t('delete', 'admin');?></button>
    <button class="btn btn-small btn-success" id="beta-reload-current"><?php echo t('reload_data', 'admin');?></button>
</div>
<table class="table table-striped table-bordered beta-list-table table-post-list">
    <thead>
        <tr>
            <th class="item-checkbox align-center">#</th>
            <th class="span1 align-center"><?php echo $sort->link('id');?></th>
            <th class="span7"><?php echo $sort->link('title');?></th>
            <th class="span2 align-center"><?php echo $sort->link('category_id');?>&nbsp;/&nbsp;<?php echo $sort->link('topic_id');?></th>
            <th class="span1 align-center">#</th>
            <th class="span2 align-center"><?php echo $sort->link('create_time');?></th>
            <th>#</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($models as $model):?>
        <tr>
            <td class="item-checkbox"><input type="checkbox" name="itemid[]" value="<?php echo $model->id;?>" /></td>
            <td class="align-center"><?php echo $model->id;?></td>
            <td>
                <?php echo $model->editLink;?>
                <form class="form-inline hidden state-update-block">
                    <label class="checkbox">
                        <?php echo CHtml::activeCheckBox($model, 'state');?><?php echo t('state_show', 'admin');?>
                    </label>
                    <label class="checkbox">
                        <?php echo CHtml::activeCheckBox($model, 'homeshow');?><?php echo t('home_show', 'admin');?>
                    </label>
                    <label class="checkbox">
                        <?php echo CHtml::activeCheckBox($model, 'hottest');?><?php echo t('hottest_show', 'admin');?>
                    </label>
                    <label class="checkbox">
                        <?php echo CHtml::activeCheckBox($model, 'recommend');?><?php echo t('recommend_show', 'admin');?>
                    </label>
                    <label class="checkbox">
                        <?php echo CHtml::activeCheckBox($model, 'istop');?><?php echo t('settop', 'admin');?>
                    </label>
                    <label class="checkbox">
                        <?php echo CHtml::activeCheckBox($model, 'disable_comment');?><?php echo t('disable_comment');?>
                    </label>
                    <input type="button" data-toggle="button" data-loading-text="<?php echo t('updating', 'admin');?>" data-complete-text="<?php echo t('update_complete', 'admin');?>" class="btn-update-state btn btn-mini" value="<?php echo t('update', 'admin');?>" />
                </form>
            </td>
            <td>
                <?php echo $model->adminCategory->postListLink;?><br />
                <?php echo $model->adminTopic->postListLink;?>
            </td>
            <td class="align-center">
                <?php echo $model->verifyLink;?><br />
                <?php echo $model->deleteLink;?>
            </td>
            <td>
                <?php echo $model->authorName;?><br />
                <?php echo $model->createTime;?>
            </td>
            <td></td>
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
	$(document).on('click', '.set-delete', {onfirmText:deleteConfirmText}, BetaAdmin.deletePost);
	$(document).on('click', '.set-verify', BetaAdmin.ajaxSetPostBoolColumn);

	$(document).on('click', '#batch-delete', {onfirmText:deleteConfirmText}, BetaAdmin.deleteMultiPosts);
	$(document).on('click', '#batch-verify', BetaAdmin.verifyMultiPosts);
	$(document).on('click', '#batch-reject', BetaAdmin.rejectMultiPosts);
	$(document).on('click', '#batch-recommend', BetaAdmin.recommendMultiPosts);
	$(document).on('click', '#batch-hottest', BetaAdmin.hottestMultiPosts);
	
	$(document).on('click', '#select-all', BetaAdmin.selectAll);
	$(document).on('click', '#reverse-select', BetaAdmin.reverseSelect);

	$(document).on('click', '.btn-update-state', function(event){
	    $(this).button('loading');alert(1);
	    $(this).button('complete');alert(1);
	    $(this).button('reset');
	});

	$('table tr').mouseenter(function(event){
		$(this).find('.state-update-block').hide().delay(250).show(1);
	});
	$('table tr').mouseleave(function(event){
		$(this).find('.state-update-block').stop(true, true).hide();
	});
});
</script>
