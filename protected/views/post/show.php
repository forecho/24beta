<div class="beta-content beta-post-show">
    <div class="beta-post-detail">
        <h1><?php echo $post->title;?></h1>
        <div class="post-extra"><span><?php echo t('post_extra_text', 'main', $post->postExtra);?></span></div>
        <div class="post-content"><?php echo $post->content;?></div>
    </div>
    <div class="beta-mini-title"><?php echo t('post_comment');?></div>
    <div class="beta-post-form">
        the form
    </div>
    <?php $this->renderPartial('/comment/list', array('comments'=>$comments));?>
</div>
<div class="beta-sidebar">
    <div class="beta-sidebar-block beta-hot-comment">
        <?php $this->renderPartial('/comment/_hot_list', array('comments'=>$hotComments));?>
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