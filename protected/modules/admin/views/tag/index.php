<div class="well btn-toolbar">
    <div class="btn-group">
        <?php echo l(t('tag_top_label', 'admin', array('{count}'=>10)), url('admin/tag/hottest', array('count'=>10)), array('class'=>'btn btn-small'));?>
        <a class="btn btn-small dropdown-toggle" data-toggle="dropdown" href="#">
            <span class="caret"></span>
        </a>
        <ul class="dropdown-menu dropdown-menu-small">
            <li><?php echo l(t('tag_top_label', 'admin', array('{count}'=>20)), url('admin/tag/hottest', array('count'=>20)));?></li>
            <li><?php echo l(t('tag_top_label', 'admin', array('{count}'=>50)), url('admin/tag/hottest', array('count'=>50)));?></li>
            <li><?php echo l(t('tag_top_label', 'admin', array('{count}'=>100)), url('admin/tag/hottest', array('count'=>100)));?></li>
        </ul>
    </div>
    <div class="btn-group">
        <?php echo l(t('tag_latest_label', 'admin', array('{count}'=>10)), url('admin/tag/latest', array('count'=>10)), array('class'=>'btn btn-small'));?>
        <a class="btn btn-small dropdown-toggle" data-toggle="dropdown" href="#">
            <span class="caret"></span>
        </a>
        <ul class="dropdown-menu dropdown-menu-small">
            <li><?php echo l(t('tag_latest_label', 'admin', array('{count}'=>20)), url('admin/tag/latest', array('count'=>20)));?></li>
            <li><?php echo l(t('tag_latest_label', 'admin', array('{count}'=>50)), url('admin/tag/latest', array('count'=>50)));?></li>
            <li><?php echo l(t('tag_latest_label', 'admin', array('{count}'=>100)), url('admin/tag/latest', array('count'=>100)));?></li>
        </ul>
    </div>
    <div class="btn-group"><?php echo l(t('tag_search', 'admin'), url('admin/tag/search'), array('class'=>'btn btn-small'));?></div>
</div>