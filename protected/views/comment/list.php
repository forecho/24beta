<div class="beta-alert beta-alert-message hide" id="beta-comment-message" data-dismiss="alert"><a class="close" href="javascript:void(0);">&times;</a><span class="text"></span></div>
<div class="beta-mini-title" id="beta-comment-list"><?php echo t('comment_list');?></div>
<?php foreach ((array)$comments as $key => $comment):?>
<dl class="beta-comment-item">
    <dt class="beta-post-extra"><span><?php echo t('comment_extra', 'main', array('{floor}'=>$key+1, '{author}'=>$comment->authorLink, '{time}'=>$comment->createTime));?></span></dt>
    <dd class="beta-comment-content"><?php echo $comment->filterContent;?></dd>
    <dd class="beta-comment-toolbar">
        <?php if (!$post->disable_comment):?>
        <a class="beta-comment-reply" href="javascript:void(0);" data-url="<?php echo aurl('post/comment', array('id'=>$comment->id));?>" rel="nofollow"><?php echo t('reply_comment');?></a>
        <?php endif;?>
        <a class="beta-comment-rating" href="javascript:void(0);" data-url="<?php echo $comment->supportUrl;?>" rel="nofollow"><?php echo t('support_comment', 'main', array($comment->up_nums));?></a>
        <a class="beta-comment-rating" href="javascript:void(0);" data-url="<?php echo $comment->againstUrl;?>" rel="nofollow"><?php echo t('against_comment', 'main', array($comment->down_nums));?></a>
        <a class="beta-comment-rating" href="javascript:void(0);" data-url="<?php echo $comment->reportUrl;?>" rel="nofollow"><?php echo t('report_comment');?></a>
    </dd>
</dl>
<?php endforeach;?>
<?php if (count($comments) === 0):?>
<div class="beta-no-comments"><?php echo t('have_no_comments');?></div>
<?php endif;?>