<div class="toolbar">
</div>
<table class="table table-striped table-bordered post-list-table">
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
<div class="toolbar">
    <button class="btn">全选</button>
    <button class="btn">反选</button>
    <button class="btn primary">通过</button>
    <button class="btn danger">拒绝</button>
    <button class="btn info">删除</button>
</div>