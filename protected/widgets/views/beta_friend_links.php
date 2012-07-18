<div class="beta-block beta-radius3px beta-links">
    <h2><?php echo $this->title;?></h2>
    <ul class="beta-block-content unstyled">
        <?php foreach($models as $model):?>
        <?php if ($model->logoValid):?><li class="logo-link"><?php echo $model->getLogoLink();?></li><?php endif;?>
        <?php $logo++; endforeach;?>
    
        <?php if ($logo > 0):?><div class="clear"></div><?php endif;?>
        
        <?php foreach($models as $model):?>
        <?php if (!$model->logoValid):?><li class="text-link"><?php echo $model->getNameLink();?></li><?php endif;?>
        <?php $text++; endforeach;?>
        
        <?php if ($text > 0):?><div class="clear"></div><?php endif;?>
        
        <?php if (empty($models)):?>
        <li class="beta-no-content-tip"><?php echo t('no_friend_links')?></li>
        <?php endif;?>
    </ul>
</div>