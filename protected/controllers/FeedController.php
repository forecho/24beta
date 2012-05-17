<?php
class FeedController extends Controller
{
    const POST_COUNT = 200;
    
    public function init()
    {
        parent::init();
        header('Content-Type:application/xml; charset=' . app()->charset);
    }
    
    public function actionTimeline()
    {
        $cmd = app()->getDb()->createCommand()
            ->where('state = :enabled', array(':enabled'=>Post::STATE_ENABLED));
        
        $rows = self::fetchPosts($cmd);
        
        $this->renderPartial('rss', array(
            'rows' => $rows,
            'feedname' => app()->name,
        ));
    }
    
    public function actionCategory($id)
    {
        $id = (int)$id;
        $categoryName = app()->getDb()->createCommand()
            ->select('name')
            ->from(TABLE_CATEGORY)
            ->where('id = :cid', array(':cid'=>$id))
            ->queryScalar();
        
        if ($categoryName === false)
            throw new CHttpException(403, t('category_is_not_found'));
        
        $cmd = app()->getDb()->createCommand()
            ->where(array('and', 'category_id = :cid', 'state = :enabled'), array(':cid' => $id, ':enabled'=>Post::STATE_ENABLED));
        
        $rows = self::fetchPosts($cmd);
        
        $feedname = $categoryName . ' - ' . app()->name;
        $this->renderPartial('rss', array(
            'rows' => $rows,
            'feedname' => $feedname,
        ));
    }
    
    public function actionTopic($id)
    {
        $id = (int)$id;
        $topicName = app()->getDb()->createCommand()
            ->select('name')
            ->from(TABLE_TOPIC)
            ->where('id = :tid', array(':tid'=>$id))
            ->queryScalar();
        
        if ($topicName === false)
            throw new CHttpException(403, t('topic_is_not_found'));
        
        $cmd = app()->getDb()->createCommand()
            ->where(array('and', 'topic_id = :tid', 'state = :enabled'), array(':tid' => $id, ':enabled'=>Post::STATE_ENABLED));
        
        $rows = self::fetchPosts($cmd);
        
        $feedname = $topicName . ' - ' . app()->name;
        $this->renderPartial('rss', array(
            'rows' => $rows,
            'feedname' => $feedname,
        ));
    }
    
    private static function fetchPosts(CDbCommand $cmd)
    {
        $cmd->from(TABLE_POST)
            ->select(array('id', 'title', 'thumbnail', 'summary', 'content', 'create_time'))
            ->order(array('create_time desc', 'id desc'))
            ->limit(self::POST_COUNT);
            
        $rows = $cmd->queryAll();
        return $rows;
    }
}