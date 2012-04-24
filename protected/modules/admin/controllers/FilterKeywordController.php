<?php
class FilterKeywordController extends AdminController
{
    public function actionList()
    {
        $models = FilterKeyword::fetchAllArray();
        
        $this->adminTitle = t('filter_keyword_list', 'admin');
        $this->render('list', array(
            'models' => $models,
        ));
    }
    
    public static function saveFilterKeywords(array $params)
    {
        $names = array();
        foreach ($params as $name => $value) {
            try {
                $result = app()->getDb()->createCommand()
                ->update(TABLE_FILTER_KEYWORD, array('replace'=>$value), 'keyword = :keyword', array(':keyword'=>$name));
            }
            catch (Exception $e) {
                array_push($names, $name);
            }
        }
        return empty($names) ? true : $names;
    }
    
    public function actionCreate()
    {
    
    }
}