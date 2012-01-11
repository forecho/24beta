<div class="beta-content beta-post-show">
    <div class="beta-post-detail">
        <h1><?php echo $post->title;?></h1>
        <div class="post-extra"><span><?php echo t('post_extra_text', 'main', $post->postExtra);?></span></div>
        <div class="post-content"><?php echo $post->content;?></div>
    </div>
    <div class="beta-mini-title"><?php echo t('post_comment');?></div>
    <div class="beta-post-form">
        the form
    </div>
    <?php $this->renderPartial('/comment/list', array('comments'=>$comments));?>
</div>
<div class="beta-sidebar">
    <div class="beta-sidebar-block beta-hot-comment">
        <?php $this->renderPartial('/comment/_hot_list', array('comments'=>$hotComments));?>
    </div>
    <?php $this->widget('BetaLatestPosts', array('title'=>t('relate_posts'), 'tid'=>$post->topic_id));?>
</div>
<div class="clear"></div>