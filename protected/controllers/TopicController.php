<?php
class TopicController extends Controller
{
    public function actionPosts($id)
    {
        $id = (int)$id;
        $topic = Topic::model()->findByPk($id);
        if ($topic === null)
            throw new CHttpException(404, t('topic_is_not_found'));
        
        $data = self::fetchTopicPosts($id);
        
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
        $criteria->order = 't.state desc, t.create_time desc, t.id desc';
        $criteria->limit = param('postCountOfPage');
        $criteria->addColumnCondition(array('topic_id' => $id))
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
        
        cs()->registerMetaTag('all', 'robots');
        $this->render('list', array(
            'topics' => $topics,
        ));
    }
}