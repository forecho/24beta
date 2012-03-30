<?php
class ConfigController extends AdminController
{
    public function actionView($categoryid)
    {
        $categoryid = (int)$categoryid;
        $cmd = app()->getDb()->createCommand()
            ->from(AdminConfig::model()->tableName())
            ->order('id asc')
            ->where('category_id = :categoryid', array(':categoryid' => $categoryid));
        $rows = $cmd->queryAll();
        
        $categoryLabels = AdminConfig::categoryLabels();
        $this->adminTitle = t('view_config_params', 'admin');
        $this->render('list', array(
            'models'=>$rows,
            'categoryLabels' => $categoryLabels,
            'categoryid' => $categoryid,
        ));
    }
    
    public function actionEdit($categoryid)
    {
        $categoryid = (int)$categoryid;
        
        if (request()->getIsPostRequest() && isset($_POST['AdminConfig'])) {
            $params = $_POST['AdminConfig'];
            $result = self::saveConfigParams($params);
            if ($result === true) {
                user()->setFlash('save_config_success', t('cofig_save_success', 'admin'));
                self::afterSaveConfig();
            }
            else
                $errorNames = $result;
        }
        
        $cmd = app()->getDb()->createCommand()
            ->from(AdminConfig::model()->tableName())
            ->order('id asc')
            ->where('category_id = :categoryid', array(':categoryid' => $categoryid));
        $rows = $cmd->queryAll();
        
        $categoryLabels = AdminConfig::categoryLabels();
        $this->adminTitle = t('edit_config_params', 'admin');
        $this->render('edit', array(
            'models'=>$rows,
            'categoryLabels' => $categoryLabels,
            'categoryid' => $categoryid,
            'errorNames' => $errorNames,
        ));
    }
    
    public static function saveConfigParams(array $params)
    {
        $names = array();
        foreach ($params as $name => $value) {
            try {
                $result = app()->getDb()->createCommand()
                    ->update(AdminConfig::model()->tableName(), array('config_value'=>$value), 'config_name = :configname', array(':configname'=>$name));
            }
            catch (Exception $e) {
                array_push($names, $name);
            }
        }
        return empty($names) ? true : $names;
    }
    
    public function afterSaveConfig()
    {
        AdminConfig::flushAllConfig();
    }
    
    public function actionEditRow($configid)
    {
        
    }

    public function actionTest()
    {
        $data = AdminConfig::flushAllConfig();
    }
}

