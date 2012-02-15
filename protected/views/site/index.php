<div class="beta-recommend-posts">
    <a href="#" target="_blank">
        <strong>超级碗和索尼克的广告</strong>
        <img src="http://www.ifanr.com/wp-content/uploads/2012/02/hand-up.jpg" alt="" />
    </a>
    <a class="separate" href="javascript:void(0);">x</a>
    <a href="#" target="_blank">
        <strong>第二期爱创会-开放式创业：“青春气息扑面而来”</strong>
        <img src="http://www.ifanr.com/wp-content/uploads/2012/02/sonic1.jpg" alt="" />
    </a>
    <a class="separate" href="javascript:void(0);">x</a>
    <a href="#" target="_blank">
        <strong>诺基亚在印度及中国：品牌优势，渠道特点</strong>
        <img src="http://www.ifanr.com/wp-content/uploads/2012/01/india131.jpg" alt="" />
    </a>
    <a class="separate" href="javascript:void(0);">x</a>
    <a href="#" target="_blank">
        <strong>Clear：一款具备“无按钮”设计的效率应用</strong>
        <img src="http://www.ifanr.com/wp-content/uploads/2012/01/Clear.jpg" alt="" />
    </a>
    <br class="clear" />
</div>
<div class="beta-content">
    <?php $this->renderPartial('/post/_summary_list', array('posts'=>$posts, 'pages'=>$pages));?>
</div>
<div class="beta-sidebar">
    <?php $this->widget('BetaHottestPosts', array('allowEmpty'=>true, 'days'=>300));?>
    <?php $this->widget('BetaLatestPosts', array('allowEmpty'=>true));?>
</div>
<br class="clear" />