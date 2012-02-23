<h3><?php echo user()->getFlash('table_caption', t('tag_list_table', 'admin'));?></h3>
<div class="btn-toolbar">
    <button class="btn btn-small">全选</button>
    <button class="btn btn-small">反选</button>
    <button class="btn btn-small btn-danger">删除</button>
</div>
<table class="table table-striped table-bordered beta-list-table">
    <thead>
        <tr>
            <th>#</th>
            <th class="span1 align-center">ID</th>
            <th class="span4"><?php echo t('tag_name');?></th>
            <th class="span1 align-center"><?php echo t('post_nums');?></th>
            <th>#</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($models as $model):?>
        <tr>
            <td class="item-checkbox"><input type="checkbox" name="itemid[]" value="<?php echo $model->id;?>" /></td>
            <td class="align-center"><?php echo $model->id;?></td>
            <td><?php echo $model->name;?></td>
            <td class="align-center"><?php echo $model->post_nums;?></td>
            <td>#</td>
        </tr>
        <?php endforeach;?>
    </tbody>
</table>
<?php if ($pages):?>
<div class="beta-pages"><?php $this->widget('CLinkPager', array('pages'=>$pages, 'htmlOptions'=>array('class'=>'pagination')));?></div>
<?php endif;?>
