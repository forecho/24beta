<?php
/**
 * 此文件为默认配置文件，请勿修改
 */

return array(
    // 网站名称
    'sitename' => '贝塔资讯',
    // 网站短描述
    'shortdesc' => '我们不是一个人在战斗',
    // 网站语言
    'language' => 'zh_cn',
    // 使用的时区
    'timezone' => 'Asia/Shanghai',
    // 记住用户登录状态的cookie时间
    'autoLoginDuration' => 3600 * 24 * 7,
    // 当前theme，不要在此修改，这是默认值，请在后台中修改
    'theme' => null,

    // 注册用户是否需要邮件激活
    'userRequiredEmailVerfiy' => false,
        
    // 每页显示的文章数量
    'postCountOfPage' => 15,
    // 每页显示的评论数量
    'commentCountOfPage' => 20,
    // 每页显示的热门评论数量
    'hotCommentCountOfPage' => 20,
    // 支持数达到多少才认为是热门评论
    'upNumsOfCommentIsHot' => 10,
    // 评论内容最短长度
    'commentMinLength' => 5,

    // 缓存数据目录
    'dataPath' => BETA_CONFIG_ROOT . DS . '..' . DS . 'data' . DS,
    // 上传文件保存目录及基本url地址，url后面要带/
    'uploadBasePath' => BETA_CONFIG_ROOT . DS . '..' . DS . '..' . DS . 'uploads' . DS,
    'uploadBaseUrl' => 'http://f.24beta.cn/',
    // 静态资源文件保存目录及基本url地址，url后面要带/
    'resourceBasePath' => BETA_CONFIG_ROOT . DS . '..' . DS . '..' . DS . 'resources' . DS,
    'resourceBaseUrl' => 'http://s.24beta.cn/',
    // theme静态资源文件保存目录及基本url地址，url后面要带/
    'themeResourceBasePath' => BETA_CONFIG_ROOT . DS . '..' . DS . '..' . DS . 'resources' . DS . 'themes' . DS,
    'themeResourceBaseUrl' => 'http://s.24beta.cn/themes/',

    /*
     * datetime format
    */
    'formatDateTime' => 'Y-m-d H:i:s',
    'formatShortDateTime' => 'Y-m-d H:i',
    'formatDate' => 'Y-m-d',
    'formatTime' => 'H:i:s',
    'formatShortTime' => 'H:i',
    
    /*
     * 前台相关参数
     */
    // 默认评论是否需要审核
    'defaultNewCommentState' => 1,
    
    
    /*
     * 管理后台相关配置
     */
    // 文章列表每页显示的文章数量
    'adminPostCountOfPage' => 30,
    // 每页显示的评论数量
    'adminCommentCountOfPage' => 0,
    // 如果简述没写，则截取内容的长度
    'subSummaryLen' => 200,
    
    
    // 简述中可以使用的html标签
    'summaryHtmlTags' => '<b><strong><a><img><p>',
);

