<?php
class CategoryController extends Controller
{
    public function actionPosts($id)
    {
        $id = (int)$id;
        $category = Category::model()->findByPk($id);
        if ($category === null)
            throw new CHttpException(403, t('category_is_not_found'));
        
        $data = self::fetchCategoryPosts($id);
        $data['category'] = $category;
        
        $this->setSiteTitle(t('category_posts', 'main', array('{name}'=>$category->name)));
        // @todo 关键字的描述没有指定
        $this->setPageKeyWords(null);
        $this->setPageDescription(null);
        
        cs()->registerMetaTag('all', 'robots');
        $this->render('posts', $data);
    }
    
    private static function fetchCategoryPosts($id)
    {
        $criteria = new CDbCriteria();
        $criteria->select = array('t.id', 't.title', 't.visit_nums', 't.comment_nums');
        $criteria->order = 't.istop, t.create_time desc, t.id desc';
        $criteria->addColumnCondition(array('category_id' => $id))
            ->addCondition('t.state = :state');
        $criteria->params += array(':state'=>Post::STATE_ENABLED);
    
        $count = Post::model()->count($criteria);
        $pages = new CPagination($count);
        $pages->setPageSize(param('postCountOfTitleListPage'));
        $pages->applyLimit($criteria);
        $posts = Post::model()->findAll($criteria);
    
        return array(
            'posts' => $posts,
            'pages' => $pages,
        );
    }
}