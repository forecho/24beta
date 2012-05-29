<?php
define('BETA_YES', 1);
define('BETA_NO', 0);

define('TABLE_POST', '{{post}}');
define('TABLE_COMMENT', '{{comment}}');
define('TABLE_CATEGORY', '{{category}}');
define('TABLE_CONFIG', '{{config}}');
define('TABLE_SPECIAL', '{{special}}');
define('TABLE_SPECIAL_POST', '{{special_post}}');
define('TABLE_TAG', '{{tag}}');
define('TABLE_POST_TAG', '{{post_tag}}');
define('TABLE_TOPIC', '{{topic}}');
define('TABLE_UPLOAD', '{{upload}}');
define('TABLE_USER', '{{user}}');
define('TABLE_FILTER_KEYWORD', '{{filter_keyword}}');

/* category state */
define('CATEGORY_STATE_IN_NAV', 1);
define('CATEGORY_STATE_NOT_IN_NAV', 0);
/* comment state */
define('COMMENT_STATE_NOT_VERIFY', -1);
define('COMMENT_STATE_DISABLED', 0);
define('COMMENT_STATE_ENABLED', 1);
/* comment rating */
define('COMMENT_RATING_SUPPORT', 1);
define('COMMENT_RATING_AGAINST', 2);
define('COMMENT_RATING_REPORT', 3);
/* special state */
define('SPECIAL_STATE_DISABLED', 0);
define('SPECIAL_STATE_ENABLED', 1);
/* user state */
define('USER_STATE_UNVERIFY', 0);
define('USER_STATE_ENABLED', 1);
define('USER_STATE_FORBIDDEN', -1);
/*
 * post type
* 0 post
* 1 vote
* 2 album
* 3 goods
*/
define('POST_TYPE_POST', 0);
define('POST_TYPE_VOTE', 1);
define('POST_TYPE_ALBUM', 2);
define('POST_TYPE_GOODS', 3);

/* post state */
define('POST_STATE_TRASH', -99);
define('POST_STATE_REJECTED', -2);
define('POST_STATE_NOT_VERIFY', -1);
define('POST_STATE_DISABLED', 0);
define('POST_STATE_ENABLED', 1);

/* upload type */
define('UPLOAD_TYPE_UNKNOWN', 0);
define('UPLOAD_TYPE_PICTURE', 1);
define('UPLOAD_TYPE_FILE', 2);
define('UPLOAD_TYPE_AUDIO', 3);
define('UPLOAD_TYPE_VIDEO', 4);


define('BAIDU_PING_URL', 'http://ping.baidu.com/ping/RPC2');




