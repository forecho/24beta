<?php
class TagController extends Controller
{
    public function actionPosts($name)
    {
        $tag = urldecode($name);
        
        $this->setSiteTitle(t('tag_posts', 'main', array('{name}'=>$tag)));
        // @todo 关键字的描述没有指定
        $this->setPageKeyWords($tag);
        $this->setPageDescription(t('tag_posts_page_description', 'main', array('{name}' => $tag)));
        cs()->registerMetaTag('all', 'robots');
        
        $cmd = app()->getDb()->createCommand()
            ->select('p.id')
            ->from(TABLE_TAG . ' t')
            ->where('t.name = :tagname', array(':tagname' => $tag))
            ->join(TABLE_POST_TAG . ' pt', 'pt.tag_id = t.id')
            ->join(TABLE_POST . ' p', 'p.id = pt.post_id');
        
        $ids = $cmd->queryColumn();
        
        if (empty($ids)) {
            $this->render('posts');
            app()->end();
        }
        
        $criteria = new CDbCriteria();
        $criteria->select = array('t.id', 't.title', 't.visit_nums', 't.comment_nums');
        $criteria->order = 't.istop, t.create_time desc, t.id desc';
        $criteria->addInCondition('t.id', $ids)
            ->addCondition('t.state = :state');
        $criteria->params += array(':state'=>Post::STATE_ENABLED);
        
        $count = Post::model()->count($criteria);
        $pages = new CPagination($count);
        $pages->setPageSize(param('postCountOfTitleListPage'));
        $pages->applyLimit($criteria);
        $posts = Post::model()->findAll($criteria);
        
        $this->render('posts', array(
            'tagname' => $tag,
            'posts' => $posts,
            'pages' => $pages,
        ));
    }
}