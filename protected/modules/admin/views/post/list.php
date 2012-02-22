<h3><?php echo user()->getFlash('table_caption', '文章列表');?></h3>
<div class="btn-toolbar">
    <button class="btn btn-small">全选</button>
    <button class="btn btn-small">反选</button>
    <button class="btn btn-small btn-primary">通过</button>
    <button class="btn btn-small btn-danger">拒绝</button>
    <button class="btn btn-small btn-info">删除</button>
</div>
<table class="table table-striped table-bordered beta-list-table">
    <thead>
        <tr>
            <th class="item-checkbox">#</th>
            <th class="item-id"><?php echo $sort->link('id');?></th>
            <th class="item-title"><?php echo $sort->link('title');?></th>
            <th class="item-datetime"><?php echo $sort->link('create_time');?></th>
            <th class="item-operation">#</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($models as $model):?>
        <tr>
            <td class="item-checkbox"><input type="checkbox" name="itemid[]" value="<?php echo $model->id;?>" /></td>
            <td class="item-id"><?php echo $model->id;?></td>
            <td class="item-title"><?php echo $model->title;?></td>
            <td class="item-datetime"><?php echo $model->createTime;?></td>
            <td class="item-operation">#</td>
        </tr>
        <?php endforeach;?>
    </tbody>
</table>
<?php if ($pages):?>
<div class="beta-pages"><?php $this->widget('CLinkPager', array('pages'=>$pages, 'htmlOptions'=>array('class'=>'pagination')));?></div>
<?php endif;?>
