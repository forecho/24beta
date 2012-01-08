<?php foreach ((array)$posts as $model):?>
<dl class="beta-post-item">
    <dt><h1><?php echo $model->titleLink;?></h1></dt>
    <dd class="post-extra"><span><?php echo t('post_extra_text', 'main', $model->postExtra);?></span></d>
    <dd class="post-summary"><?php echo $model['summary'];?></dd>
    <dd class="post-item-toolbar">
        <strong><?php echo l(t('view_detail'), $model->url, array('target'=>'_blank'));?></strong>
        <?php echo t('post_toolbar_text', 'main', $model->postToolbar);?>
    </dd>
</dl>
<?php endforeach;?>
<?php if ($pages):?>
<div class="beta-pages"><?php $this->widget('CLinkPager', array('pages'=>$pages));?></div>
<?php endif;?>