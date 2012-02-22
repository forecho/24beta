<?php $this->widget('BetaSpecialPosts', array('token'=>'site_hottest_posts'));?>

<div class="beta-content">
    <?php $this->renderPartial('/post/_summary_list', array('posts'=>$posts, 'pages'=>$pages));?>
</div>
<div class="beta-sidebar">
    <?php $this->widget('BetaCommentTopPosts', array('allowEmpty'=>true, 'days'=>30));?>
    <?php $this->widget('BetaVisitTopPosts', array('allowEmpty'=>true, 'days'=>30));?>
</div>
<div class="clear"></div>