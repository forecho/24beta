<?php
class TopicController extends Controller
{
    public function actionPosts($id)
    {
        $id = (int)$id;
        $topic = Topic::model()->findByPk($id);
        if ($topic === null)
            throw new CHttpException(403, t('topic_is_not_found'));
        
        $data = self::fetchTopicPosts($id);
        $data['topic'] = $topic;
        
        $this->setSiteTitle(t('topic_posts', 'main', array('{name}'=>$topic->name)));
        // @todo 关键字的描述没有指定
        $this->setPageKeyWords(null);
        $this->setPageDescription(null);
        
        cs()->registerMetaTag('all', 'robots');
        $this->render('posts', $data);
    }
    
    private static function fetchTopicPosts($id)
    {
        $criteria = new CDbCriteria();
        $criteria->select = array('t.id', 't.title', 't.visit_nums', 't.comment_nums');
        $criteria->order = 't.istop desc, t.create_time desc';
        $criteria->addColumnCondition(array('t.topic_id' => $id))
            ->addCondition('t.state = :state');
        $criteria->params += array(':state'=>Post::STATE_ENABLED);
    
        $count = Post::model()->count($criteria);
        $pages = new CPagination($count);
        $pages->setPageSize(param('postCountOfTitleListPage'));
        $pages->applyLimit($criteria);
        $posts = Post::model()->findAll($criteria);
    
        return array(
            'posts' => $posts,
            'pages' => $pages,
        );
    }

    public function actionList()
    {
        $criteria = new CDbCriteria();
        $criteria->order = 'orderid desc, post_nums desc, id asc';
        $topics = Topic::model()->findAll($criteria);
        
        $this->setSiteTitle(t('all_topic_list'));
        $this->setPageKeyWords(null);
        $this->setPageDescription(t('all_topics_description'));
        
        cs()->registerMetaTag('all', 'robots');
        $this->render('list', array(
            'topics' => $topics,
        ));
    }
}