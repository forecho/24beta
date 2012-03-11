<?php
class ConfigController extends Controller
{
    public function actionView($categoryid)
    {
        $categoryid = (int)$categoryid;
        $cmd = app()->getDb()->createCommand()
            ->from(AdminConfig::model()->tableName())
            ->order('id asc')
            ->where('category_id = :categoryid', array(':categoryid' => $categoryid));
        $rows = $cmd->queryAll();
        
        $this->render('list', array('models'=>$rows));
    }
    
    public function actionEdit($categoryid)
    {
    
    }
    
    public function actionEditRow($configid)
    {
        
    }
}