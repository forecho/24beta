<?php
class AdminConfig extends Config
{
    const CATEGORY_CUSTOM = 0;
    const CATEGORY_SYSTEM = 10;
    const CATEGORY_DISPLAY = 20;
    const CATEGORY_UI = 30;
    const CATEGORY_PERFORMANCE = 40;
    const CATEGORY_SNS = 50;
    
    /**
     * Returns the static model of the specified AR class.
     * @return AdminConfig the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
    
    public static function categoryLabels()
    {
        // @todo not complete
        return array(
            self::CATEGORY_CUSTOM => t('custome_config_params', 'admin'),
            self::CATEGORY_SYSTEM => t('system_config_params', 'admin'),
            self::CATEGORY_DISPLAY => t('display_config_params', 'admin'),
            self::CATEGORY_UI => t('ui_config_params', 'admin'),
            self::CATEGORY_PERFORMANCE => t('performance_config_params', 'admin'),
            self::CATEGORY_SNS => t('sns_config_params', 'admin'),
        );
    }
    
    public static function flushAllConfig()
    {
        $rows = app()->getDb()->createCommand()
            ->select(array('config_name', 'config_value'))
            ->from(self::model()->tableName())
            ->queryAll();
        
        if (empty($rows)) return false;
        
        $rows = CHtml::listData($rows, 'config_name', 'config_value');
        $data = "<?php\nreturn " . var_export($rows, true) . ';';
        $filename = dp('setting.config.php');
        return file_put_contents($filename, $data);
    }
}