<h3><?php echo $this->adminTitle;?></h3>
<table class="table table-striped table-bordered beta-list-table">
    <tr>
        <td class="column-label"><?php echo CHtml::activeLabel($model, 'id');?></td>
        <td><?php echo $model->id;?></td>
    </tr>
    <tr>
        <td class="column-label"><?php echo CHtml::activeLabel($model, 'email');?></td>
        <td><?php echo $model->email;?></td>
    </tr>
    <tr>
        <td class="column-label"><?php echo CHtml::activeLabel($model, 'name');?></td>
        <td><?php echo $model->name;?></td>
    </tr>
    <tr>
        <td class="column-label"><?php echo CHtml::activeLabel($model, 'state');?></td>
        <td><?php echo $model->stateText;?></td>
    </tr>
    <tr>
        <td class="column-label"><?php echo CHtml::activeLabel($model, 'create_time');?></td>
        <td><?php echo $model->createTimeText;?></td>
    </tr>
    <tr>
        <td class="column-label"><?php echo CHtml::activeLabel($model, 'create_ip');?></td>
        <td><?php echo $model->create_ip;?></td>
    </tr>
    <tr>
        <td class="column-label"><?php echo CHtml::activeLabel($model, 'token');?></td>
        <td><?php echo $model->token;?></td>
    </tr>
</table>