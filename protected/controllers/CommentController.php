<?php
class CommentController extends Controller
{
    public function actionList($pid)
    {
        $pid = (int)$pid;
        $post = Post::model()->findByPk($pid, 'state != :state', array(':state'=>POST_DISABLED));
        if (null === $post)
            throw new CHttpException(404, t('post_is_not_found'));
        
        $comments = self::fetchList($pid);
        
        $this->renderPartial('list', array(
            'comments' => $comments,
        ));
    }
    
    private static function fetchList($pid)
    {
        $criteria = new CDbCriteria();
        $criteria->order = 'id desc';
        $criteria->limit = param('commentCountOfPage');
        $criteria->addColumnCondition(array(
                'post_id' => $pid,
                'state' => COMMENT_ENABLED,
            ));
        
        $comments = Comment::model()->findAll($criteria);
        
        return $comments;
    }
    
    public function actionHotlist($pid)
    {
        $pid = (int)$pid;
        $post = Post::model()->findByPk($pid, 'state != :state', array(':state'=>POST_DISABLED));
        if (null === $post)
            throw new CHttpException(404, t('post_is_not_found'));
        
        $comments = self::fetchHotList($pid);
        
        $this->renderPartial('list', array(
            'comments' => $comments,
        ));
    }
    
    private static function fetchHotList($pid)
    {
        if (null === $criteria)
            $criteria = new CDbCriteria();
    
        $criteria->order = 'id desc';
        $criteria->limit = param('commentCountOfPage');
        $criteria->addColumnCondition(array(
                'post_id' => $pid,
                'state' => COMMENT_ENABLED,
            ))
            ->addCondition('up_nums > :hot_nums');
    
        $comments = Comment::model()->findAll($criteria, array(':hot_nums'=>param('upNumsOfCommentIsHot')));
    
        return $comments;
    }
}