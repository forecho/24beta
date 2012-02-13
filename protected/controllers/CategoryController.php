<?php
class CategoryController extends Controller
{
    public function actionPosts($cid)
    {
        $cid = (int)$cid;
        $category = Category::model()->findByPk($cid);
        if ($category === null)
            throw new CHttpException(404, t('category_is_not_found'));
        
        $data = self::fetchTopicPosts($cid);
        
        $this->setSiteTitle(t('category_posts', 'main', array('{name}'=>$category->name)));
        // @todo 关键字的描述没有指定
        $this->setPageKeyWords(null);
        $this->setPageDescription(null);
        
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