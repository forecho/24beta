<?php foreach ((array)$posts as $model):?>
<dl class="beta-post-item">
    <dt><h1><?php echo $model->titleLink;?></h1></dt>
    <dd class="post-extra"><span>ugmbbc发布于 2011-12-15 14:01:26 | 2029 次阅读 | 2次推荐</span></dd>
    <dd class="post-summary"><?php echo $model['summary'];?></dd>
    <dd class="post-item-toolbar">
        <strong><?php echo l(t('view_detail'), $model->url, array('target'=>'_blank'));?></strong>
        <?php printf(t('post_toolbar_text'), $model->comment_nums, $model->score_nums, $model->rating);?>
    </dd>
</dl>
<?php endforeach;?>
<?php if ($pages):?>
<div class="beta-pages"><?php $this->widget('CLinkPager', array('pages'=>$pages));?></div>
<?php endif;?>