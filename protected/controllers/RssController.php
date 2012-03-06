<?php
class RssController extends Controller
{
    const POST_COUNT = 500;
    
    public function actionLatest()
    {
        $cmd = app()->getDb()->createCommand()
            ->where('state = :enabled', array(':enabled'=>Post::STATE_ENABLED));
        
        $rows = self::fetchPosts($cmd);
        
        $this->renderPartial('list', array('rows'=>$rows));
    }
    
    private static function fetchPosts(CDbCommand $cmd)
    {
        $cmd->from(Post::model()->tableName())
            ->select('*')
            ->order(array('create_time desc', 'id desc'))
            ->limit(self::POST_COUNT);
            
        $rows = $cmd->queryAll();
        return $rows;
    }
}