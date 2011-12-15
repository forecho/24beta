<div class="beta-content">
    <?php foreach ($posts as $p):?>
    <dl class="post-item">
        <dt><h1><?php echo $p->titleLink;?></h1></dt>
        <dd class="post-extra">ugmbbc发布于 2011-12-15 14:01:26 | 2029 次阅读 | 2次推荐</dd>
        <dd class="post-summary"><?php echo $p['summary'];?></dd>
        <dd class="post-item-toolbar">
            <strong><?php echo l(t('view_detail'), $p->url, array('target'=>'_blank'));?></strong>
            <?php printf(t('post_toolbar_text'), $p->comment_nums, $p->score_nums, $p->rating);?>
        </dd>
    </dl>
    <?php endforeach;?>
    <div class="beta-pages"><?php $this->widget('CLinkPager', array('pages'=>$pages));?></div>
</div>
<div class="beta-sidebar">
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