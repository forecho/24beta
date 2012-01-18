<?php
class CommentController extends Controller
{
    public function actionList($postid, $page = 1)
    {
        $postid = (int)$postid;
        $post = Post::model()->findByPk($pid, 'state != :state', array(':state'=>Post::POST_DISABLED));
        if (null === $post)
            throw new CHttpException(404, t('post_is_not_found'));
        
        $comments = Comment::fetchList($postid, $page);
        
        $this->renderPartial('list', array(
            'comments' => $comments,
        ));
    }
    
    public function actionHotlist($pid, $page = 1)
    {
        $postid = (int)$postid;
        $post = Post::model()->findByPk($pid, 'state != :state', array(':state'=>Post::STATE_DISABLED));
        if (null === $post)
            throw new CHttpException(404, t('post_is_not_found'));
        
        $comments = Comment::fetchHotList($postid, $page);
        
        $this->renderPartial('list', array(
            'comments' => $comments,
        ));
    }
    
    public function actionCreate()
    {
        $model = new CommentForm();
        $model->attributes = $_POST['CommentForm'];
        if ($model->validate() && $model->save()) {
            echo '1';
        }
        else {
            echo '0';
        }
        exit(0);
    }
}