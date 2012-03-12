<div class="beta-content">
    <div class="beta-alert alert-success">
    <h2><?php echo $title;?></h2>
    <ul class="beta-success-items">
        <li><a href="<?php echo url('post/create');?>">我再投递一篇</a></li>
        <li><a href="<?php echo url('post/show', array('id'=>$postid));?>">查看刚才投递的文章</a></li>
        <li><a href="<?php echo app()->homeUrl?>">返回网站首页</a></li>
    </ul>
    </div>
</div>
<div class="beta-sidebar"></div>
<div class="clear"></div>