<?php foreach ((array)$posts as $model):?>
<dl class="beta-post-item beta-radius3px">
    <dt><h1><?php echo $model->titleLink;?></h1></dt>
    <dd class="beta-post-extra"><span>
        <?php echo t('post_author_time', 'main', array('{author}'=>$model->authorName, '{time}'=>$model->createTime));?>&nbsp;&nbsp;&nbsp;&nbsp;
        <?php if ($model->category) echo $model->categoryLink;?>
        <?php if ($model->topic) echo $model->topicLink;?>
    </span></dd>
    <dd class="beta-post-summary">
        <div class="beta-thank"><?php echo t('thanks_contribute', 'main', array('{contributor}'=>$model->contributorLink));?></div>
        <div class="beta-post-content"><?php echo $model->summary;?></div>
    </dd>
    <dd class="beta-post-toolbar">
        <?php echo l(t('view_detail'), $model->url, array('target'=>'_blank'));?>
        <?php echo t('post_toolbar_text', 'main', $model->postToolbar);?>
    </dd>
</dl>
<?php endforeach;?>
<?php if ($pages):?>
<div class="beta-pages"><?php $this->widget('CLinkPager', array('pages'=>$pages));?></div>
<?php endif;?>

<?php cs()->registerScriptFile(sbu('libs/jquery.lazyload.min.js'), CClientScript::POS_END);?>

<script type="text/javascript">
$(function(){
	Beta24.imageLazyLoad($('.beta-post-item .beta-post-summary img.lazy'));
});
</script>