<div class="beta-sidebar-block">
    <h2><?php echo $this->title;?></h2>
    <ul class="content unstyled">
    <?php foreach($models as $model):?>
        <li><?php echo $model->getTitleLink($this->titleLen);?></li>
    <?php endforeach;?>
    <?php if (empty($models)):?>
        <li class="beta-no-posts"><?php echo t('no_posts')?></li>
    <?php endif;?>
    </ul>
</div>