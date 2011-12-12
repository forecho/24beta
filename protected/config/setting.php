<?php
/**
 * 此文件为默认配置文件，请勿修改
 */

define('POST_DISABLED', 0);
define('POST_ENABLED', 10);
define('POST_TOP', 20);

define('COMMENT_DISABLED', 0);
define('COMMENT_ENABLED', 1);

return array(
    // 网站名称
    'sitename' => '24beta',
    // 域名，与当前使用的域名一致
    'domain' => '24beta.com',
    // 网站语言
    'language' => 'zh_cn',
    // 使用的时区
    'timezone' => 'Asia/Shanghai',
    // 当前theme
    'theme' => 'cnbeta',
    // 记住用户登录状态的cookie时间
    'autoLoginDuration' => 3600 * 24 * 7,
        
    'userRequiredEmailVerfiy' => false,
        
    // 每页显示的文章数量
    'postCountOfPage' => 15,
    // 每页显示的评论数量
    'commentCountOfPage' => 20,
    // 每页显示的热门评论数量
    'hotCommentCountOfPage' => 20,
    // 支持数达到多少才认为是热门评论
    'upNumsOfCommentIsHot' => 10,

    // 缓存数据目录
    'dataPath' => dirname(__FILE__) . DS . '..' . DS . 'data' . DS,
    // 上传文件保存目录及基本url地址，url后面要带/
    'uploadBasePath' => dirname(__FILE__) . DS . '..' . DS . '..' . DS . 'uploads' . DS,
    'uploadBaseUrl' => 'http://f.24beta.cn/',
    // 静态资源文件保存目录及基本url地址，url后面要带/
    'resourceBasePath' => dirname(__FILE__) . DS . '..' . DS . '..' . DS . 'resources' . DS,
    'resourceBaseUrl' => 'http://s.24beta.cn/',
    // theme静态资源文件保存目录及基本url地址，url后面要带/
    'themeResourceBasePath' => dirname(__FILE__) . DS . '..' . DS . '..' . DS . 'resources' . DS . 'themes' . DS,
    'themeResourceBaseUrl' => 'http://s.24beta.cn/themes/',

    /*
     * datetime format
    */
    'formatDateTime' => 'Y-m-d H:i:s',
    'formatShortDateTime' => 'Y-m-d H:i',
    'formatDate' => 'Y-m-d',
    'formatTime' => 'H:i:s',
    'formatShortTime' => 'H:i',
);