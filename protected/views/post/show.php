<div class="beta-content beta-post-show beta-radius3px">
    <div class="beta-post-detail">
        <h1><?php echo $post->title;?></h1>
        <div class="beta-post-extra"><span><?php echo t('post_extra_text', 'main', $post->postExtra);?></span></div>
        <div class="beta-thank"><?php echo t('thanks_contribute', 'main', array('{contributor}'=>$post->contributorLink));?></div>
        <div class="beta-post-content"><?php echo $post->content;?></div>
        <?php if ($post->tags):?>
        <div class="beta-post-tags"><?php echo $post->tagLinks;?></div>
        <?php endif;?>
        <?php if ($post->source):?>
        <div class="beta-post-source"><?php echo t('source_label');?><?php echo $post->sourceLink;?></div>
        <?php endif;?>
    </div>
    <div class="beta-mini-title"><?php echo t('post_comment');?></div>
    <?php if ($post->disable_comment):?>
        <div class="disable_comment"><?php echo t('this_post_is_disable_comment');?></div>
    <?php else:?>
        <div class="beta-create-form"><?php $this->renderPartial('/comment/_create_form', array('comment'=>$comment));?></div>
    <?php endif;?>
    <?php $this->renderPartial('/comment/list', array('comments'=>$comments, 'post'=>$post));?>
</div>
<div class="beta-sidebar">
    <div class="beta-block beta-hot-comment beta-radius3px">
        <?php $this->renderPartial('/comment/_hot_list', array('comments'=>$hotComments, 'post'=>$post));?>
    </div>
    <?php $this->widget('BetaLatestPosts', array('title'=>t('relate_posts'), 'tid'=>$post->topic_id));?>
</div>
<div class="clear"></div>

<div class="hide ajax-jsstr">
    <span class="ajax-send"><?php echo t('ajax_send');?></span>
    <span class="ajax-fail"><?php echo t('ajax_fail');?></span>
    <span class="ajax-rules-invalid"><?php echo t('ajax_comment_rules_invalid');?></span>
    <span class="ajax-has-joined"><?php echo t('you_have_joined');?></span>
</div>

<?php cs()->registerScriptFile(sbu('libs/jquery.lazyload.min.js'), CClientScript::POS_END);?>

<script type="text/javascript">
$(function(){
	Beta24.imageLazyLoad($('.beta-post-detail .beta-post-content img.lazy'));
	BetaPost.increaseVisitNums(<?php echo $post->id;?>, '<?php echo aurl('post/visit');?>');
	$(document).on('click', '.beta-comment-rating', BetaComment.rating);
	$(document).on('click', '.beta-comment-reply', BetaComment.reply);
});
</script>