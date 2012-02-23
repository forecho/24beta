<div class="well btn-toolbar">
    <div class="btn-group">
        <?php echo l(t('topic_top_label', 'admin', array('{count}'=>10)), url('admin/topic/hottest', array('count'=>10)), array('class'=>'btn btn-small'));?>
        <a class="btn btn-small dropdown-toggle" data-toggle="dropdown" href="#">
            <span class="caret"></span>
        </a>
        <ul class="dropdown-menu dropdown-menu-small">
            <li><?php echo l(t('topic_top_label', 'admin', array('{count}'=>20)), url('admin/topic/hottest', array('count'=>20)));?></li>
            <li><?php echo l(t('topic_top_label', 'admin', array('{count}'=>50)), url('admin/topic/hottest', array('count'=>50)));?></li>
            <li><?php echo l(t('topic_top_label', 'admin', array('{count}'=>100)), url('admin/topic/hottest', array('count'=>100)));?></li>
        </ul>
    </div>
    <div class="btn-group"><?php echo l(t('create_topic', 'admin'), url('admin/topic/create'), array('class'=>'btn btn-small'));?></div>
    <div class="btn-group"><?php echo l(t('topic_list_table', 'admin'), url('admin/topic/list'), array('class'=>'btn btn-small'));?></div>
</div>