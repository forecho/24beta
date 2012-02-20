<?php
return array(
    'guest_name' => '匿名人士',
    'post_is_not_found' => '此文章不存在',
    'topic_is_not_found' => '主题不存在',
    'category_is_not_found' => '分类不存在',
    'cateogry_has_subcategory' => '该分类下有子分类存在，不能直接删除',
    'cateogry_has_posts' => '该分类下有文章存在，不能直接删除',
    'topic_has_subtopic' => '该主题下有子主题存在，不能直接删除',
    'topic_has_posts' => '该主题下有文章存在，不能直接删除',
        
        
    /*
     * model Post attributeLabels
     */
    'category' => '分类',
    'topic' => '主题',
    'title' => '标题',
    'create_time' => '添加时间',
    'create_ip' => 'IP',
    'score' => '评分',
    'score_nums' => '评分次数',
    'comment_nums' => '评论数',
    'digg_nums' => '支持数',
    'visit_nums' => '浏览数',
    'user_id' => '用户ID',
    'user_name' => '用户名',
    'source' => '来源',
    'tags' => '标签',
    'state' => '状态',
    'istop' => '置顶',
    'disable_comment' => '禁止评论',
    'thumbnail' => '缩略图',
    'summary' => '简述',
    'content' => '内容',
    'contributor_id' => '投稿者ID',
    'contributor' => '投稿者',
    'contributor_site' => '投稿者网站',
    'contributor_email' => '投稿者邮箱',

    /* form model LoginForm */
    'email' => '邮箱',
    'username' => '大名',
    'password' => '密码',
    'remember_me' => '下次自动登录',
    'agreement' => '我已经认真阅读并同意《<a href="{policyurl}" target="_blank">使用协议</a>》。',
    'welcome_signup' => '欢迎加入' . app()->name,
    'autologin' => '下次自动登录&nbsp;|&nbsp;' . l('忘记密码了', url('site/resetpwd')),
    'user_login' => '登录',
    'user_signup' => '注册',
    'username_tip' => '第一印象很重要，起个响亮的名号吧',
    'quick_login_link' => '&gt;&nbsp;已经拥有豆瓣帐号?&nbsp;' . l('直接登录', url('site/login')),
    'quick_signup_link' => '&gt;&nbsp;还没有豆瓣帐号?&nbsp;' . l('立即注册', url('site/signup')),
    'user_logout' => '退出',

    /* Specail model */
    'special_token' => '标识',
    'special_name' => '名称',
    'special_desc' => '描述',

    /*
     * model Comment attributeLabels
     */
    'post_id' => '文章ID',
    'up_nums' => '支持数',
    'down_nums' => '反对数',
    'report_nums' => '举报数',
    'captcha' => '验证码',
    'refresh_captcha' => '换一张',

    'post_comment' => '发表评论',
    'view_detail' => '查看详情',
    'post_toolbar_text' => '已有{comment_nums}个评论&nbsp;&nbsp;|&nbsp;&nbsp;{score_nums}次评分&nbsp;&nbsp;|&nbsp;&nbsp;评分:{score}分',
    'post_extra_text' => '{author}&nbsp;发布于&nbsp;{time}&nbsp;&nbsp;|&nbsp;&nbsp;<em class="beta-visit-nums">{visit}</em>次阅读&nbsp;&nbsp;<em class="beta-digg-nums">{digg}</em>次推荐',
    'comment_list' => '评论列表',
    'hot_comment_list' => '热门评论',
    'have_no_comments' => '当前暂无评论',
    'comment_extra' => '第&nbsp;<b>{floor}</b>&nbsp;楼&nbsp;{author}&nbsp;发表于&nbsp;{time}',
    'reply_comment' => '回复',
    'support_comment' => '支持(<span class="beta-comment-join-nums">{n}</span>)',
    'against_comment' => '反对(<span class="beta-comment-join-nums">{n}</span>)',
    'report_comment' => '举报',
    'comment_quote_title' => '引用%s的评论:',
        
    'comment_top_posts' => '最具争议文章排行',
    'visit_top_posts' => '人气文章排行',
    'hottest_posts' => '热门文章排行',
    'latest_posts' => '最新发布文章',
    'relate_posts' => '相关文章',
    'no_posts' => '当前暂无文章',
        
    'source_label' => '来源：',
    'tag_label' => '标签',
    'prev_page_label' => '上一页',
    'next_page_label' => '下一页',
    'this_post_is_disable_comment' => '当前文章已经关闭评论',

    /*
     * layout
     */
    'return_top' => '返回顶部 ^',

    /*
     * post show
     */
    'thanks_contribute' => '感谢{contributor}的投递',

    /*
     * comment create form
     */
    'your_name' => '大名',
    'your_site' => '网站',
    'your_email' => '邮箱',
    'comment_content' => '内容',
    'submit' => '递交',
    'reset' => '重填',
    'close' => '关闭',

    'ajax_send' => '发送数据中...',
    'ajax_fail' => '请求错误.',

    'comment_content_min_length' => '评论内容不能少于{minlength}个字哦～～～',
    'ajax_comment_rules_invalid' => '请输入评论内容和验证码后再发布',
    'ajax_comment_done' => '评论成功.',
    'ajax_comment_error' => '评论失败, %s不正确',

    'thank_your_join' => '感谢您的参与',
    'you_have_joined' => '您已经参与过了，谢谢',
    'operation_error' => '发生系统错误',

    /*
     * post create
     */
    'contribute_post' => '投递文章',
    'contribute_post_success' => '感谢您的投递，文章标题：{title}',
    'post_title' => '文章标题',
    'post_source' => '文章来源',
    'post_contributor' => '您的大名',
    'post_contributor_site' => '您的网站',
    'post_contributor_email' => '您的邮箱',

    /* topic */
    'all_topic_list' => '所有主题列表',
    'topics_posts' => '专题：{name}',

    /* category */
    'category_posts' => '分类：{name}',

    /* BetaHottestPosts */
    'special_token_is_null' => 'token不能为空',
);



