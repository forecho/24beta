<?php
class PostController extends Controller
{
    public function actionShow($id)
    {
        $id = (int)$id;
        if ($id <= 0)
            throw new CHttpException(404, t('post_is_not_found'));
        
        $post = Post::model()->published()->findByPk($id);
        if (null === $post)
            throw new CHttpException(404, t('post_is_not_found'));

        $comments = Comment::fetchList($id);
        $hotComments = Comment::fetchHotList($id);
        $comment = new CommentForm();
        $comment->post_id = $id;
        
        $this->render('show', array(
            'post' => $post,
            'comment' => $comment,
            'comments' => $comments,
            'hotComments' => $hotComments,
        ));
    }
    
    public function actionVisit()
    {
        $id = (int)$_POST['id'];
        if (!request()->getIsAjaxRequest() || !request()->getIsPostRequest() || $id <= 0)
            throw new CHttpException(500);
        
        $post = Post::model()->findByPk($id);
        if (null === $post)
            throw new CHttpException(404, t('post_is_not_found'));
        $post->visit_nums += 1;
        $post->update(array('visit_nums'));
        echo $post->visit_nums;
        exit(0);
    }
    
    public function actionComment()
    {
        if (!request()->getIsAjaxRequest() || !request()->getIsPostRequest())
            throw new CHttpException(500);
    
        $data = array();
        $model = new CommentForm();
        $model->attributes = $_POST['CommentForm'];
        if ($model->validate() && ($comment = $model->save())) {
            $data['errno'] = 0;
            $data['text'] = t('ajax_comment_done');
            $data['html'] = $this->renderPartial('/comment/_one', array('comment'=>$comment), true); // @todo 反回此条评论的html代码
        }
        else {
            $data['errno'] = 1;
            $attributes = array_keys($model->getErrors());
            foreach ($attributes as $attribute)
                $labels[] = $model->getAttributeLabel($attribute);
            $errstr = join(' ', $labels);
            $data['text'] = sprintf(t('ajax_comment_error'), $errstr);
        }
        echo json_encode($data);
        exit(0);
    }
    
    
}