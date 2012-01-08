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
        $this->render('show', array(
            'post' => $post,
            'comments' => $comments,
            'hotComments' => $hotComments,
        ));
    }
    
    
}