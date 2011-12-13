<?php
class TopicController extends Controller
{
    public function actionPosts($tid)
    {
        $tid = (int)$tid;
        $data = self::fetchTopicPosts($tid);
        
        $this->render('posts', $data);
    }
    
    private static function fetchTopicPosts($tid)
    {
        $criteria = new CDbCriteria();
        $criteria->order = 't.state desc, t.create_time desc, t.id desc';
        $criteria->limit = param('postCountOfPage');
        $criteria->addColumnCondition(array('topic_id' => $tid))
            ->addCondition('t.state != :state');
    
        $count = Post::model()->count($criteria, array(':state'=>Post::STATE_DISABLED));
        $pages = new CPagination($count);
        $pages->setPageSize(param('postCountOfPage'));
        $pages->applyLimit($criteria);
        $posts = Post::model()->with('category', 'topic')->findAll($criteria, array(':state'=>Post::STATE_DISABLED));
    
        return array(
            'posts' => $posts,
            'pages' => $pages,
        );
    }

    public function actionList()
    {
        $criteria = new CDbCriteria();
        $criteria->order = 'id asc';
        $topics = Topic::model()->findAll($criteria);
        
        $this->render('list', array(
            'topics' => $topics,
        ));
    }
}