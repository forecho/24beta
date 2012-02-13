<?php if ($comment):?>
<dl class="beta-comment-item">
    <dt class="beta-post-extra"><span><?php echo t('comment_extra', 'main', array('{floor}'=>$key+1, '{author}'=>$comment->authorName, '{time}'=>$comment->createTime));?></span></dt>
    <dd class="beta-comment-content"><?php echo $comment->filterContent;?></dd>
    <dd class="beta-comment-toolbar">
        <a class="beta-comment-reply" href="javascript:void(0);" data-url="<?php echo aurl('post/comment', array('id'=>$comment->id));?>" rel="nofollow"><?php echo t('reply_comment');?></a>
        <a class="beta-comment-rating" href="javascript:void(0);" data-url="<?php echo $comment->supportUrl;?>" rel="nofollow"><?php echo t('support_comment', 'main', array($comment->up_nums));?></a>
        <a class="beta-comment-rating" href="javascript:void(0);" data-url="<?php echo $comment->againstUrl;?>" rel="nofollow"><?php echo t('against_comment', 'main', array($comment->down_nums));?></a>
        <a class="beta-comment-rating" href="javascript:void(0);" data-url="<?php echo $comment->reportUrl;?>" rel="nofollow"><?php echo t('report_comment');?></a>
    </dd>
</dl>
<?php endif;?>