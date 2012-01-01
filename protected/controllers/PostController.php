<?php
class PostController extends Controller
{
    public function actionShow($id)
    {
        $id = (int)$id;
        $post = Post::model()->findByPk($id, 'state != :state', array(':state'=>Post::STATE_DISABLED));
        
        if (null === $post)
            throw new CHttpException(404, t('post_is_not_found'));

        $comments = range(0, 10);
        $this->render('show', array(
            'post' => $post,
            'comments' => $comments,
        ));
    }
    
    
}