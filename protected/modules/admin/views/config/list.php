<h3><?php echo $this->adminTitle;?></h3>
<table class="table table-striped table-bordered beta-list-table">
    <thead>
        <tr>
            <th class="span1 align-center">ID</th>
            <th class="span2 align-right"><?php echo t('config_name');?></th>
            <th class="span4"><?php echo t('config_value');?></th>
            <th class="span4"><?php echo t('config_description');?></th>
            <th>#</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($models as $model):?>
        <tr>
            <td class="align-center"><?php echo $model['id'];?></td>
            <td class="align-right"><?php echo $model['config_name'];?></td>
            <td><?php echo $model['config_value'];?></td>
            <td><?php echo nl2br($model['config_description']);?></td>
            <td>&nbsp;</td>
        </tr>
        <?php endforeach;?>
    </tbody>
</table>
