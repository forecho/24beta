<?php
class CategoryController extends Controller
{
    public function actionPosts($cid)
    {
        $cid = (int)$cid;
        $data = self::fetchTopicPosts($cid);
        
        $this->render('posts', $data);
    }
    
    private static function fetchCategoryPosts($cid)
    {
        $criteria = new CDbCriteria();
        $criteria->order = 't.state desc, t.create_time desc, t.id desc';
        $criteria->limit = param('postCountOfPage');
        $criteria->addColumnCondition(array('category_id' => $cid))
            ->addCondition('t.state != :state');
    
        $count = Post::model()->count($criteria, array(':state'=>POST_DISABLED));
        $pages = new CPagination($count);
        $pages->setPageSize(param('postCountOfPage'));
        $pages->applyLimit($criteria);
        $posts = Post::model()->with('category', 'topic')->findAll($criteria, array(':state'=>POST_DISABLED));
    
        return array(
            'posts' => $posts,
            'pages' => $pages,
        );
    }
}