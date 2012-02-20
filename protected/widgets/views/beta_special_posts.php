<div class="beta-recommend-posts">
<?php foreach ((array)$model->posts as $index => $post):?>
    <?php if ($index != 0):?>
    <a class="separate" href="javascript:void(0);">x</a>
    <?php endif;?>
    <a href="<?php echo $post->absoluteUrl?>" target="_blank">
        <strong><?php echo $post->title;?></strong>
        <img src="<?php echo $post->thumbnailUrl?>" alt="<?php echo $post->title;?>" />
    </a>
<?php endforeach;?>
    <div class="clear"></div>
</div>