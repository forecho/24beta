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
        if (!request()->getIsAjaxRequest() || !request()->getIsPostRequest())
            throw new CHttpException(500);

        $data = array();
        $model = new CommentForm();
        $model->attributes = $_POST['CommentForm'];
        if ($model->validate() && ($comment = $model->save())) {
            $data['errno'] = 0;
            $data['text'] = t('ajax_comment_done');
            $data['html'] = 'x'; // @todo 反回此条评论的html代码
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