<div class="beta-content beta-post-show beta-radius3px">
    <div class="beta-post-detail">
        <h1><?php echo $post->title;?></h1>
        <div class="beta-post-extra"><span>
            <?php echo $post->showExtraInfo;?>&nbsp;&nbsp;
            <?php if ($post->category) echo $post->categoryLink;?>
            <?php if ($post->topic) echo $post->topicLink;?>
        </span></div>
        <div class="beta-thank"><?php echo t('thanks_contribute', 'main', array('{contributor}'=>$post->contributorLink));?></div>
        <div class="beta-post-content"><?php echo $post->content;?></div>
        
        <?php if ($post->tags):?>
        <div class="beta-post-tags"><?php echo t('tag_label');?><?php echo $post->tagLinks;?></div>
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
    <div class="beta-block">
        <script type="text/javascript"><!--
            google_ad_client = "ca-pub-9725980429199769";
            /* beta_336x280 */
            google_ad_slot = "9661689878";
            google_ad_width = 336;
            google_ad_height = 280;
            //-->
        </script>
        <script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script>
    </div>
    <?php $this->widget('BetaLatestPosts', array('title'=>t('relate_posts'), 'tid'=>$post->topic_id));?>
    <div class="beta-block">
        <script type="text/javascript"><!--
            google_ad_client = "ca-pub-9725980429199769";
            /* beta_336x280 */
            google_ad_slot = "9661689878";
            google_ad_width = 336;
            google_ad_height = 280;
            //-->
        </script>
        <script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script>
    </div>
    <?php $this->widget('BetaLatestPosts');?>
</div>
<div class="clear"></div>

<div class="hide ajax-jsstr">
    <span class="ajax-send"><?php echo t('ajax_send');?></span>
    <span class="ajax-fail"><?php echo t('ajax_fail');?></span>
    <span class="ajax-rules-invalid"><?php echo t('ajax_comment_rules_invalid');?></span>
    <span class="ajax-has-joined"><?php echo t('you_have_joined');?></span>
</div>

<script type="text/javascript">
$(function(){
	BetaPost.increaseVisitNums(<?php echo $post->id;?>, '<?php echo aurl('post/visit');?>');
	$(document).on('click', '.beta-comment-rating', BetaComment.rating);
	$(document).on('click', '.beta-comment-reply', BetaComment.reply);
});
</script>