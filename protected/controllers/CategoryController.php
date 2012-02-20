<?php
class CategoryController extends Controller
{
    public function actionPosts($id)
    {
        $id = (int)$id;
        $category = Category::model()->findByPk($id);
        if ($category === null)
            throw new CHttpException(404, t('category_is_not_found'));
        
        $data = self::fetchCategoryPosts($id);
        
        $this->setSiteTitle(t('category_posts', 'main', array('{name}'=>$category->name)));
        // @todo 关键字的描述没有指定
        $this->setPageKeyWords(null);
        $this->setPageDescription(null);
        
        $this->render('posts', $data);
    }
    
    private static function fetchCategoryPosts($id)
    {
        $criteria = new CDbCriteria();
        $criteria->order = 't.state desc, t.create_time desc, t.id desc';
        $criteria->limit = param('postCountOfPage');
        $criteria->addColumnCondition(array('category_id' => $id))
            ->addCondition('t.state != :state');
        $criteria->params = $criteria->params + array(':state'=>POST_DISABLED);
    
        $count = Post::model()->count($criteria);
        $pages = new CPagination($count);
        $pages->setPageSize(param('postCountOfPage'));
        $pages->applyLimit($criteria);
        $posts = Post::model()->with('category', 'topic')->findAll($criteria);
    
        return array(
            'posts' => $posts,
            'pages' => $pages,
        );
    }
}