<?php if (user()->hasFlash('order_id_save_result_success')):?>
<div class="alert alert-success fade in">
    <a href="javascript:void(0);" data-dismiss="alert" class="close">&times;</a>
    <?php echo user()->getFlash('order_id_save_result_success');?>
</div>
<?php endif;?>
<?php if (user()->hasFlash('order_id_save_result_error')):?>
<div class="alert alert-error fade in">
    <a href="javascript:void(0);" data-dismiss="alert" class="close">&times;</a>
    <?php echo user()->getFlash('order_id_save_result_error');?>
</div>
<?php endif;?>

<h3><?php echo user()->getFlash('table_caption', t('category_list_table', 'admin'));?></h3>

<?php echo CHtml::form(url('admin/category/updateOrderID'), 'post', array('class'=>'form-horizontal'));?>
<table class="table table-striped table-bordered beta-list-table">
    <thead>
        <tr>
            <th class="span1 align-center"><?php echo $sort->link('orderid');?></th>
            <th class="span1 align-center"><?php echo $sort->link('id');?></th>
            <th class="span5"><?php echo $sort->link('name');?></th>
            <th class="span1 align-center"><?php echo $sort->link('post_nums');?></th>
            <th><a class="label label-important" href="<?php echo url('admin/category/create');?>"><?php echo t('create_category', 'admin');?></a></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($models as $model):?>
        <tr>
            <td class="item-orderid"><input type="text" name="<?php echo sprintf('itemid[%d]', $model->id);?>" value="<?php echo $model->orderid;?>" class="input-mini" /></td>
            <td class="align-center"><?php echo $model->id;?></td>
            <td><?php echo $model->postsLink;?></td>
            <td class="align-center"><?php echo $model->post_nums;?></td>
            <td>
                <?php echo l(t('edit', 'admin'), url('admin/category/create', array('id'=>$model->id)));?>
            </td>
        </tr>
        <?php endforeach;?>
    </tbody>
</table>
<?php if ($pages):?>
<div class="beta-pages"><?php $this->widget('CLinkPager', array('pages'=>$pages, 'htmlOptions'=>array('class'=>'pagination')));?></div>
<?php endif;?>

<?php if (count($models) > 0):?>
<fieldset>
    <div class="form-actions">
        <input type="submit" value="<?php echo t('submit', 'admin');?>" class="btn btn-primary" />
        <a class="btn" href="<?php echo url('admin/category/create');?>"><?php echo t('create_category', 'admin');?></a>
    </div>
</fieldset>
<?php endif;?>
<?php echo CHtml::endForm();?>