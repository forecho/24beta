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
        if (request()->getIsPostRequest()) {
            $content = trim($_POST['kwcontent']);
            if ($content) {
                $keywords = explode("\n", $content);
                foreach ((array)$keywords as $kw) {
                    $kwArray = explode(',', $kw);
                    $kwArray = array_unique($kwArray);
                    $model = new FilterKeyword();
                    $model->keyword = trim($kwArray[0]);
                    $model->replace = trim($kwArray[1]);
                    try {
                        if (!$model->save()) {
                            $error['keyword'] = $kw;
                            $error['message'] = implode('; ', $model->getErrors('keyword')) . implode('; ', $model->getErrors('replace'));
                            $errors[] = $error;
                        }
                    }
                    catch (Exception $e) {
                        $error['keyword'] = $kw;
                        $error['message'] = $e->getMessage();
                        $errors[] = $kw;
                    }
                    unset($model);
                }
            }
        }
        
        $this->adminTitle = t('create_filter_keyword', 'admin');
        $this->render('create', array('errors'=>$errors));
    }
}