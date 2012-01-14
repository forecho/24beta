<?php
class PostController extends Controller
{
    public function actionShow($id)
    {
        $id = (int)$id;
        $post = Post::model()->published()->findByPk($id);
        
        if (null === $post)
            throw new CHttpException(404, t('post_is_not_found'));

        $comments = Comment::fetchList($id);
        $hotComments = Comment::fetchHotList($id);
        $comment = new CommentForm();
        if (request()->getIsPostRequest()) {
            $comment->attributes = $_POST['CommentForm'];
            $comment->validate();
        }
        $this->render('show', array(
            'post' => $post,
            'comment' => $comment,
            'comments' => $comments,
            'hotComments' => $hotComments,
        ));
    }
    
    
}