<?php $this->widget('betaSpecialPosts', array('token'=>'site_hottest_posts'));?>

<div class="beta-content">
    <?php $this->renderPartial('/post/_summary_list', array('posts'=>$posts, 'pages'=>$pages));?>
</div>
<div class="beta-sidebar">
    <?php $this->widget('BetaCommentTopPosts', array('allowEmpty'=>true, 'days'=>300));?>
    <?php $this->widget('BetaLatestPosts', array('allowEmpty'=>true));?>
</div>
<div class="clear"></div>