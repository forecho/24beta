<?php
class FilterKeywordController extends AdminController
{
    public function filters()
    {
        return array(
            'ajaxOnly + edit',
            'postOnly + edit',
        );
    }
    
    public function actionList()
    {
        $data = FilterKeyword::fetchAllArray();
        
        $this->adminTitle = t('filter_keyword_list', 'admin');
        $this->render('list', $data);
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
    
    public function actionEdit($callback)
    {
        $id = request()->getPost('kwid');
        $model = FilterKeyword::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404);
        
        $keyword = trim(request()->getPost('keyword'));
        $replace = trim(request()->getPost('replace'));
        
        $model->keyword = $keyword;
        $model->replace = $replace;
        $result = $model->save();
        $data = array(
            'errno' => (int)!$result,
            'message' => $model->getError('keyword') . $model->getError('replace'),
        );
        
        BetaBase::jsonp($callback, $data);
        exit(0);
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
                FilterKeyword::updateCacheFile();
            }
        }
        
        $this->adminTitle = t('create_filter_keyword', 'admin');
        $this->render('create', array('errors'=>$errors));
    }
}