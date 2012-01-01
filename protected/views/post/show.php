<div class="beta-content beta-post-show">
    <div class="beta-post-detail">
        <h1><?php echo $post->title;?></h1>
        <div class="post-extra"><span>ugmbbc发布于 2011-12-15 14:01:26 | 2029 次阅读 | 2次推荐</span></div>
        <div class="post-content"><?php echo $post->content;?></div>
    </div>
    <div class="beta-mini-title">发表评论</div>
    <div class="beta-post-form">
        dd
    </div>
    <div class="beta-mini-title">发表评论</div>
    <?php foreach ((array)$comments as $comment):?>
    <dl class="beta-comment-item">
        <dt class="post-extra"><span>第3楼 匿名人士 发表于 2012-01-01 18:51:36</span></dt>
        <dd class="comment-content">WM手机2010的时候是穿越到2016.没想到MZ是1996，这中间的20年？求解释<?php echo $comment->content;?></dd>
        <dd class="comment-toolbar">
                        回复 支持(142) 反对(2)   举报
        </dd>
    </dl>
    <?php endforeach;?>
</div>
<div class="beta-sidebar">
    <div class="beta-sidebar-block beta-hot-comment">
        <div class="beta-mini-title">热门评论</div>
        <?php foreach ((array)$comments as $comment):?>
        <dl class="beta-comment-item">
            <dt class="post-extra"><span>第3楼 匿名人士 发表于 2012-01-01 18:51:36</span></dt>
            <dd class="comment-content">WM手机2010的时候是穿越到2016.没想到MZ是1996，这中间的20年？求解释<?php echo $comment->content;?></dd>
            <dd class="comment-toolbar">
                            回复 支持(142) 反对(2)   举报
            </dd>
        </dl>
        <?php endforeach;?>
    </div>
    <div class="beta-sidebar-block">
        <h2>最近发表文章</h2>
        <ul class="content unstyled">
            <li>惠普决定保留webOS系统 转向开源项目(122)</li>
            <li>《时代周报》:失控的腾讯帝国 (121)</li>
            <li>雷军：用互联网的思想重造手机(118)</li>
            <li>[组图+视频]惠普公司新版“四道杠”LO...(115)</li>
        </ul>
    </div>
    <div class="beta-sidebar-block">
        <h2>最近发表文章</h2>
        <ul class="content unstyled">
            <li>惠普决定保留webOS系统 转向开源项目(122)</li>
            <li>《时代周报》:失控的腾讯帝国 (121)</li>
            <li>雷军：用互联网的思想重造手机(118)</li>
            <li>[组图+视频]惠普公司新版“四道杠”LO...(115)</li>
        </ul>
    </div>
</div>
<div class="clear"></div>