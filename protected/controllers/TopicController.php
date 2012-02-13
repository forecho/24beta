<?php
class TopicController extends Controller
{
    public function actionPosts($tid)
    {
        $tid = (int)$tid;
        $topic = Topic::model()->findByPk($tid);
        if ($topic === null)
            throw new CHttpException(404, t('topic_is_not_found'));
        
        $data = self::fetchTopicPosts($tid);
        
        $this->setSiteTitle(t('topic_posts', 'main', array('{name}'=>$topic->name)));
        // @todo 关键字的描述没有指定
        $this->setPageKeyWords(null);
        $this->setPageDescription(null);
        
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
        
        $this->setSiteTitle(t('all_topic_list'));
        // @todo 关键字的描述没有指定
        $this->setPageKeyWords(null);
        $this->setPageDescription(null);
        
        $this->render('list', array(
            'topics' => $topics,
        ));
    }
}