<h3><?php echo user()->getFlash('table_caption', $this->adminTitle);?></h3>
<div class="btn-toolbar">
    <button class="btn btn-small" id="select-all"><?php echo t('select_all', 'admin');?></button>
    <button class="btn btn-small" id="reverse-select"><?php echo t('reverse_select', 'admin');?></button>
    <?php if (strtolower($this->action->id) == 'verify'):?>
    <button class="btn btn-small btn-primary" id="batch-verify" data-src="<?php echo url('admin/post/multiVerify');?>"><?php echo t('set_batch_verify', 'admin');?></button>
    <button class="btn btn-small btn-primary" id="batch-reject" data-src="<?php echo url('admin/post/multiReject');?>"><?php echo t('set_batch_reject', 'admin');?></button>
    <?php else:?>
    <button class="btn btn-small btn-primary" id="batch-recommend" data-src="<?php echo url('admin/post/multiRecommend');?>"><?php echo t('setrecommend', 'admin');?></button>
    <button class="btn btn-small btn-primary" id="batch-hottest" data-src="<?php echo url('admin/post/multiHottest');?>"><?php echo t('sethottest', 'admin');?></button>
    <?php endif;?>
    <?php if (strtolower($this->action->id) == 'trash'):?>
    <button class="btn btn-small btn-danger" id="batch-delete" data-src="<?php echo url('admin/post/multiDelete');?>"><?php echo t('forever_delete', 'admin');?></button>
    <?php else:?>
    <button class="btn btn-small btn-danger" id="batch-trash" data-src="<?php echo url('admin/post/multiTrash');?>"><?php echo t('trash_post', 'admin');?></button>
    <?php endif;?>
    <button class="btn btn-small btn-success" id="beta-reload-current"><?php echo t('reload_data', 'admin');?></button>
</div>
<table class="table table-striped table-bordered beta-list-table table-post-list">
    <thead>
        <tr>
            <th class="item-checkbox align-center">#</th>
            <th class="span1 align-center"><?php echo $sort->link('id');?></th>
            <th class="span6"><?php echo $sort->link('title');?></th>
            <th class="span2 align-center"><?php echo $sort->link('category_id');?>&nbsp;/&nbsp;<?php echo $sort->link('topic_id');?></th>
            <th class="span1 align-center"><?php echo $sort->link('comment_nums');?></th>
            <th class="span2 align-center"><?php echo $sort->link('create_time');?></th>
            <th class="span1 align-center">#</th>
            <th>#</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($models as $model):?>
        <tr>
            <td class="item-checkbox"><input type="checkbox" name="itemid[]" value="<?php echo $model->id;?>" /></td>
            <td class="align-center post-preivew-link">
                <?php echo $model->id;?>
                <div class="hidden quick-links"><?php echo $model->previewLink;?></div>
            </td>
            <td class="post-quick-edit">
                <?php echo $model->editLink;?>
                <form class="form-inline hidden state-update-block" method="post" action="<?php echo url('admin/post/quickUpdate', array('id'=>$model->id));?>">
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
                    <button data-toggle="button" data-loading-text="<?php echo t('updating', 'admin');?>" data-error-text="<?php echo t('update_error', 'admin')?>" data-complete-text="<?php echo t('update_complete', 'admin');?>" class="btn-update-state btn btn-mini"><?php echo t('update', 'admin');?></button>
                </form>
            </td>
            <td>
                <?php echo $model->adminCategory->postListLink;?><br />
                <?php echo $model->adminTopic->postListLink;?>
            </td>
            <td class="align-center"><?php echo $model->commentNumsBadgeHtml;?><br />
            </td>
            <td>
                <?php echo $model->authorName;?><br />
                <?php echo $model->createTime;?>
            </td>
            <td class="align-center">
                <?php if (strtolower($this->action->id) != 'trash'):?>
                <?php echo $model->trashLink;?><br />
                <?php endif;?>
                <?php echo $model->infoLink;?>
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
	$(document).on('click', '.set-trash, .set-delete', {onfirmText:deleteConfirmText}, BetaAdmin.trashPost);

	$(document).on('click', '#batch-delete, #batch-trash', {onfirmText:deleteConfirmText}, BetaAdmin.deleteMultiPosts);
	$(document).on('click', '#batch-recommend', BetaAdmin.recommendMultiPosts);
	$(document).on('click', '#batch-hottest', BetaAdmin.hottestMultiPosts);
	
	$(document).on('click', '#select-all', BetaAdmin.selectAll);
	$(document).on('click', '#reverse-select', BetaAdmin.reverseSelect);

	$(document).on('click', '.btn-update-state', BetaAdmin.quickUpdate);

	$('table td.post-quick-edit').mouseenter(function(event){
		$(this).find('.state-update-block').hide().delay(200).show(1);
	});
	$('table td.post-quick-edit').mouseleave(function(event){
		$(this).find('.state-update-block').stop(true, true).hide();
	});
	$('table td.post-preivew-link').mouseenter(function(event){
		$(this).find('.quick-links').hide().delay(150).show(1);
	});
	$('table td.post-preivew-link').mouseleave(function(event){
		$(this).find('.quick-links').stop(true, true).hide();
	});
});
</script>

