<h3><?php echo $this->adminTitle;?></h3>
<div class="btn-toolbar">
    <a class="btn btn-small btn-danger" href="<?php echo url('admin/user/resetpassword', array('id'=>$model->id));?>"><?php echo t('reset_password', 'admin');?></a>
    <a class="btn btn-small" href="<?php echo url('admin/user/create', array('id'=>$model->id));?>"><?php echo t('edit_user', 'admin');?></a>
</div>
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
        <td><?php echo $model->createTime;?></td>
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