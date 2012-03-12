<div class="well btn-toolbar">
    <?php foreach ($categoryLabels as $cid => $label):?>
    <div class="btn-group"><?php echo l($label, url('admin/config/view', array('categoryid'=>$cid)), array('class'=>'btn btn-small'));?></div>
    <?php endforeach;?>
</div>

<h3><?php echo $this->adminTitle;?></h3>
<table class="table table-striped table-bordered beta-config-table">
    <thead>
        <tr>
            <th class="span1 align-center">ID</th>
            <th class="span2 align-right"><?php echo t('config_name');?></th>
            <th class="span4"><?php echo t('config_value');?></th>
            <th class="span4"><?php echo l(t('edit_config_params', 'admin'), url('admin/config/edit', array('categoryid'=>$categoryid)), array('class'=>'btn btn-small btn-warning'));?></th>
            <th>#</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($models as $model):?>
        <tr>
            <td class="align-center"><?php echo $model['id'];?></td>
            <td class="align-right"><?php echo $model['config_name'];?></td>
            <td><?php echo h($model['config_value']);?></td>
            <td><?php echo nl2br($model['config_description']);?></td>
            <td>&nbsp;</td>
        </tr>
        <?php endforeach;?>
    </tbody>
</table>
