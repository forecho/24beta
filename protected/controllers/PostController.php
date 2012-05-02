<?php
class PostController extends Controller
{
    public function filters()
    {
        return array(
            'ajaxOnly + visit',
            'postOnly + visit',
        );
    }
    
    
    public function actionShow($id)
    {
        $id = (int)$id;
        if ($id <= 0)
            throw new CHttpException(404, t('post_is_not_found'));
        
        $cacheID = sprintf(param('cache_post_id'), $id);
        $cachePostId = app()->cache->get($cacheID);
        if ($cachePostId === false && !user()->checkAccess('enter_admin_system'))
            $post = Post::model()->published()->findByPk($id);
        else
            $post = Post::model()->findByPk($id);
        
        if (null === $post)
            throw new CHttpException(403, t('post_is_not_found'));

        $comments = Comment::fetchList($id);
        $hotComments = Comment::fetchHotList($id);
        $comment = new CommentForm();
        $comment->post_id = $id;
        
        $this->setSiteTitle($post->title);
        $this->setPageDescription($post->summary);
        $this->setPageKeyWords($post->tagText);
        
        cs()->registerMetaTag('all', 'robots');
        $this->render('show', array(
            'post' => $post,
            'comment' => $comment,
            'comments' => $comments,
            'hotComments' => $hotComments,
        ));
    }
    
    public function actionVisit($callback)
    {
        $callback = strip_tags(trim($callback));
        $id = (int)$_POST['id'];
        if ($id <= 0)
            throw new CHttpException(500);
        
        $post = Post::model()->findByPk($id);
        if (null === $post)
            throw new CHttpException(404, t('post_is_not_found'));
        $post->visit_nums += 1;
        $post->update(array('visit_nums'));
        echo $callback . '(' . $post->visit_nums . ')';
        exit(0);
    }
    
    public function actionComment($callback, $id = 0)
    {
        $id = (int)$id;
        $callback = strip_tags(trim($callback));
        
        if (!request()->getIsAjaxRequest() || !request()->getIsPostRequest() || empty($callback))
            throw new CHttpException(500);
        
        $data = array();
        $model = new CommentForm();
        $model->attributes = $_POST['CommentForm'];
        $model->content = h($model->content);
        
        if ($id > 0 && $quote = Comment::model()->findByPk($id)) {
            $quoteTitle = sprintf(t('comment_quote_title'), $quote->authorName);
            $html = '<fieldset class="beta-comment-quote"><legend>' . $quoteTitle . '</legend>' . $quote->content . '</fieldset>';
            $model->content = $html . $model->content;
        }
        
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
        echo $callback . '(' . json_encode($data) . ')';
        exit(0);
    }
    
    public function actionCreate()
    {
        $form = new PostForm();
        if (request()->getIsPostRequest() && isset($_POST['PostForm'])) {
            $form->attributes = $_POST['PostForm'];
            if ($form->validate()) {
                $post = $form->save();
                if (!$post->hasErrors()) {
                    user()->setFlash('success_post_id', $post->id);
                    $this->redirect(url('post/success'));
                    exit(0);
                }
            }
        }
        else {
            $key = param('sess_post_create_token');
            if (!app()->session->contains($key) || empty(app()->session[$key]))
                app()->session->add($key, uniqid('beta', true));
            else {
                $token = app()->session[$key];
                $tempPictures = Upload::model()->findAllByAttributes(array('token'=>$token));
            }
        }

        $captchaWidget = $form->hasErrors('captcha') ? $this->widget('BetaCaptcha', array(), true) : $this->widget('BetaCaptcha', array('skin'=>'defaultLazy'), true);
        $captchaClass = $form->hasErrors('captcha') ? 'error' : 'hide';
        
        $this->setSiteTitle(t('contribute_post'));
        
        cs()->registerMetaTag('noindex, follow', 'robots');
        $this->render('create', array(
            'form' => $form,
            'captchaClass' => $captchaClass,
            'captchaWidget' => $captchaWidget,
            'tempPictures' => $tempPictures,
        ));
    }
    
    public function actionSuccess()
    {
        $postid = user()->getFlash('success_post_id');
        if (empty($postid))
            $this->redirect(app()->homeUrl);
        
        $cacheID = sprintf(param('cache_post_id'), $postid);
        app()->cache->set($cacheID, $postid, param('expire_after_create_post_successs_post_id'));
        
        $this->setSiteTitle(t('contribute_post_success'));
        
        cs()->registerMetaTag('noindex, follow', 'robots');
        $this->render('create_success', array(
            'title'=>t('contribute_post_success'),
            'postid'=>$postid,
        ));
    }

}