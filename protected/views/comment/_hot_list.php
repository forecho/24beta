<div class="beta-mini-title"><?php echo t('hot_comment_list');?></div>
<?php foreach ((array)$comments as $key => $comment):?>
<dl class="beta-comment-item">
    <dt class="post-extra"><span><?php echo t('comment_extra', 'main', array('{floor}'=>$key+1, '{author}'=>$comment->authorLink, '{time}'=>$comment->createTime));?></span></dt>
    <dd class="comment-content"><?php echo $comment->filterContent;?></dd>
    <dd class="comment-toolbar">
        <a href="#"><?php echo t('reply_comment');?></a>
        <a href="#"><?php echo t('support_comment', 'main', array($comment->up_nums));?></a>
        <a href="#"><?php echo t('against_comment', 'main', array($comment->down_nums));?></a>
        <a href="#"><?php echo t('report_comment');?></a>
    </dd>
</dl>
<?php endforeach;?>

<?php if (count($comments) === 0):?>
<div class="beta-no-comments"><?php echo t('have_no_comments');?></div>
<?php endif;?>