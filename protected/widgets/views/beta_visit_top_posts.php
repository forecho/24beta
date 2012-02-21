<div class="beta-block beta-radius3px">
    <h2><?php echo $this->title;?></h2>
    <ul class="beta-block-content unstyled">
    <?php foreach($models as $model):?>
        <li><?php echo $model->getTitleLink($this->titleLen);?><span class="cgray f12px">(<?php echo $model->visit_nums;?>)</span></li>
    <?php endforeach;?>
    <?php if (empty($models)):?>
        <li class="beta-no-content-tip"><?php echo t('no_posts')?></li>
    <?php endif;?>
    </ul>
</div>