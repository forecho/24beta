<?php
class AdminPost extends Post
{
    public static function fetchList($criteria = null, $sort = true, $pages = true)
    {
        $criteria = ($criteria === null) ? new CDbCriteria() : $criteria;
        $criteria->limit = param('adminPostCountOfPage');
        $criteria->order = 'id desc';
         
        if ($sort) {
            $sort  = new CSort('Post');
            $sort->defaultOrder = 'id desc';
            $sort->applyOrder($criteria);
        }
         
        if ($pages) {
            $count = Post::model()->count($criteria);
            $pages = new CPagination($count);
            $pages->setPageSize($criteria->limit);
            $pages->applyLimit($criteria);
        }
         
        $models = Post::model()->findAll($criteria);
         
        $data = array(
            'models' => $models,
            'sort' => $sort,
            'pages' => $pages,
        );
         
        return $data;
    }
}