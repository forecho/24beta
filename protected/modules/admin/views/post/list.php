<h3><?php echo user()->getFlash('table_caption', t('post_list_table', 'admin'));?></h3>
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
            <th class="item-checkbox align-center">#</th>
            <th class="span1 align-center"><?php echo $sort->link('id');?></th>
            <th class="span7"><?php echo $sort->link('title');?></th>
            <th class="span2 align-center"><?php echo $sort->link('create_time');?></th>
            <th>#</th>
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
                <?php echo l(t('edit', 'admin'), url('admin/post/create', array('id'=>$model->id)));?>
                <?php echo l(t('delete', 'admin'), url('admin/post/delete', array('id'=>$model->id)));?>
                <?php
                    if ($model->state == AdminPost::STATE_DISABLED)
                        echo l(t('setshow', 'admin'), url('admin/post/verify', array('id'=>$model->id)));
                    else
                        echo l(t('sethide', 'admin'), url('admin/post/unverify', array('id'=>$model->id)));
                ?>
            </td>
        </tr>
        <?php endforeach;?>
    </tbody>
</table>
<?php if ($pages):?>
<div class="beta-pages"><?php $this->widget('CLinkPager', array('pages'=>$pages, 'htmlOptions'=>array('class'=>'pagination')));?></div>
<?php endif;?>
