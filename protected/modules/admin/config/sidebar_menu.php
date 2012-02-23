<?php
return array(
    array(
        'title' => t('shortcut', 'admin'),
        'url' => url('admin/default/shortcut'),
        'htmlOptions' => array('target'=>'main'),
    ),
    array(
        'title' => t('post_manage', 'admin'),
        'url' => 'javascript:void(0);',
        'htmlOptions' => array('target'=>'main'),
        'subs' => array(
            array('title'=>t('create_post', 'admin'), 'url'=>url('admin/post/create'), 'htmlOptions'=>array('target'=>'_blank')),
            array('title'=>t('verify_post', 'admin'), 'url'=>url('admin/post/verify'), 'htmlOptions'=>array('target'=>'main')),
            array('title'=>t('today_post', 'admin'), 'url'=>url('admin/post/today'), 'htmlOptions'=>array('target'=>'main')),
            array('title'=>t('query_post', 'admin'), 'url'=>url('admin/post/search'), 'htmlOptions'=>array('target'=>'main')),
            array('title'=>t('post_tag', 'admin'), 'url'=>url('admin/tag/index'), 'htmlOptions'=>array('target'=>'main')),
            array('title'=>t('post_topic', 'admin'), 'url'=>url('admin/topic/index'), 'htmlOptions'=>array('target'=>'main')),
            array('title'=>t('post_category', 'admin'), 'url'=>url('admin/category/index'), 'htmlOptions'=>array('target'=>'main')),
        ),
    ),
    array(
        'title' => t('comment_manage', 'admin'),
        'url' => url('admin/comment/index'),
        'htmlOptions' => array('target'=>'main'),
    ),
    array(
        'title' => t('user_manage', 'admin'),
        'url' => url('admin/user/index'),
        'htmlOptions' => array('target'=>'main'),
    ),
    array(
        'title' => t('system_tool', 'admin'),
        'url' => url('admin/tool/index'),
        'htmlOptions' => array('target'=>'main'),
    ),
    array(
        'title' => t('system_setting', 'admin'),
        'url' => url('admin/setting/index'),
        'htmlOptions' => array('target'=>'main'),
    ),
    array(
        'title' => t('system_about', 'admin'),
        'url' => 'javascript:void(0);',
        'htmlOptions' => array('target'=>'main'),
        'subs' => array(
            array('title'=>t('about_us', 'admin'), 'url'=>url('admin/post/verify'), 'htmlOptions'=>array('target'=>'main')),
            array('title'=>t('our_team', 'admin'), 'url'=>url('admin/post/create'), 'htmlOptions'=>array('target'=>'main')),
            array('title'=>t('provision', 'admin'), 'url'=>url('admin/post/today'), 'htmlOptions'=>array('target'=>'main')),
        ),
    ),
    array(
        'title' => t('user_logout'),
        'url' => url('site/logout'),
        'htmlOptions' => array('target'=>'_top'),
    ),

);