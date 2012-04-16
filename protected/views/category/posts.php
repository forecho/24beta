<div class="beta-content">
    <div class="beta-block beta-radius3px">
        <h2><?php echo t('category_posts', 'main', array('{name}'=>$category->name));?></h2>
        <ul class="beta-block-content beta-post-list unstyled">
            <?php foreach ((array)$posts as $model):?>
            <li><?php echo $model->titleLink;?><span class="cgray">(<?php echo $model->visit_nums;?>)</span></li>
            <?php endforeach;?>
            <div class="clear"></div>
        </ul>
    </div>
    <?php if ($pages->pageCount > 1):?>
    <div class="beta-pages"><?php $this->widget('CLinkPager', array('pages'=>$pages));?></div>
    <?php endif;?>
</div>
<div class="beta-sidebar">
    <?php $this->widget('BetaVisitTopPosts', array('allowEmpty'=>true, 'days'=>30, 'cid'=>$category->id));?>
</div>
<div class="clear"></div>