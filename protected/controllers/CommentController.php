<?php
class CommentController extends Controller
{
    public function actionList($pid, $page = 1)
    {
        $postid = (int)$pid;
        $post = Post::model()->findByPk($postid, 'state = :state', array(':state'=>POST_STATE_ENABLED));
        if (null === $post)
            throw new CHttpException(403, t('post_is_not_found'));
        
        $comments = Comment::fetchList($postid, $page);
        
        $this->renderPartial('list', array(
            'comments' => $comments,
        ));
    }
    
    public function actionHotlist($pid, $page = 1)
    {
        $postid = (int)$postid;
        $post = Post::model()->findByPk($pid, 'state != :state', array(':state'=>POST_STATE_DISABLED));
        if (null === $post)
            throw new CHttpException(403, t('post_is_not_found'));
        
        $comments = Comment::fetchHotList($postid, $page);
        
        $this->renderPartial('list', array(
            'comments' => $comments,
        ));
    }
    
    public function actionCreate($id = 0, $callback)
    {
        // @todo 暂时无用
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

    public function actionSupport($id, $callback)
    {
        self::rating('up_nums', $id, $callback);
        exit(0);
    }

    public function actionAgainst($id, $callback)
    {
        self::rating('down_nums', $id, $callback);
        exit(0);
    }

    public function actionReport($id, $callback)
    {
        self::rating('report_nums', $id, $callback);
        exit(0);
    }
    
    private static function rating($field, $id, $callback)
    {
//         sleep(2);
        $id = (int)$id;
        $callback = strip_tags(trim($callback));
        $field = strip_tags(trim($field));
        if (!request()->getIsAjaxRequest() || !request()->getIsPostRequest() || $id <= 0)
            throw new CHttpException(500);
        
        $counters = array($field => 1);
        try {
            $nums = Comment::model()->updateCounters($counters, 'id = :commentid', array(':commentid'=>$id));
            $data['errno'] = (int)($nums === 0);
            $data['text'] = ($nums === 0) ? t('operation_error') : t('thank_your_join');
            echo $callback . '(' . json_encode($data) . ')';
            exit(0);
        }
        catch (Exception $e) {
            throw new CHttpException(500);
        }
    }
}