<?php if ($hottest):?>
<div class="beta-hottest-posts">
<?php foreach ($hottest as $index => $post):?>
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
<?php endif;?>

<div class="beta-content">
    <?php $this->renderPartial('/post/_summary_list', array('posts'=>$posts, 'pages'=>$pages));?>
</div>
<div class="beta-sidebar">
    <div class="beta-block">
        <script type="text/javascript">/*24beta_336x280，创建于2012-3-8*/ var cpro_id = 'u797747';</script><script src="http://cpro.baidu.com/cpro/ui/c.js" type="text/javascript"></script>
    </div>
    <?php $this->widget('BetaCommentTopPosts', array('allowEmpty'=>true, 'days'=>30));?>
    <?php $this->widget('BetaVisitTopPosts', array('allowEmpty'=>true, 'days'=>30));?>
    <div class="beta-block">
        <script type="text/javascript">/*24beta_336x280，创建于2012-3-8*/ var cpro_id = 'u797747';</script><script src="http://cpro.baidu.com/cpro/ui/c.js" type="text/javascript"></script>
    </div>
    <!-- editor recommend posts start -->
    <?php if ($recommend):?>
    <div class="beta-block beta-radius3px beta-recommend-posts">
        <h2><?php echo t('recommend_posts');?></h2>
        <?php foreach($recommend as $index => $post):?>
        <dl class="row<?php echo $index%2;?>">
            <dt><?php echo $post->titleLink;?></dt>
            <dd><?php echo $post->getSubSummary(90);?></dd>
        </dl>
        <?php endforeach;?>
    </div>
    <?php endif;?>
    <!-- editor recommend posts end -->
    <div class="beta-block">
        <script type="text/javascript">
            alimama_pid="mm_12551250_1665796_9863081";
            alimama_titlecolor="0000FF";
            alimama_descolor ="000000";
            alimama_bgcolor="FFFFFF";
            alimama_bordercolor="E6E6E6";
            alimama_linkcolor="008000";
            alimama_bottomcolor="FFFFFF";
            alimama_anglesize="0";
            alimama_bgpic="0";
            alimama_icon="0";
            alimama_sizecode="36";
            alimama_width=336;
            alimama_height=280;
            alimama_type=2;
        </script>
        <script src="http://a.alimama.cn/inf.js" type="text/javascript"></script>
    </div>
    <!-- recommend comments start -->
    <?php if ($comments):?>
    <div class="beta-block beta-radius3px beta-recommend-comments">
        <h2><?php echo t('recommend_comments');?></h2>
        <?php foreach($comments as $index => $comment):?>
        <dl class="row<?php echo $index%2;?>">
            <dd><?php echo $comment->filterContent;?></dd>
            <dt><em><?php echo $comment->post->titleLink;?></em></dt>
        </dl>
        <?php endforeach;?>
    </div>
    <?php endif;?>
    <!-- recommend comments end -->
</div>
<div class="clear"></div>

