<?php
class AdminConfig extends Config
{
    const TYPE_SYSTEM = 0;
    const TYPE_CUSTOM = 1;
    
    const CATEGORY_CUSTOM = 1;
    
    const CATEGORY_SYSTEM = 10;
    const CATEGORY_SYSTEM_SITE = 11;
    const CATEGORY_SYSTEM_CACHE = 13;
    const CATEGORY_SYSTEM_ATTACHMENTS = 14;
    
    const CATEGORY_DISPLAY = 20;
    const CATEGORY_DISPLAY_TEMPLATE = 21;
    const CATEGORY_DISPLAY_UI = 22;
    
    const CATEGORY_SNS = 30;
    const CATEGORY_SNS_INTERFACE = 31;
    const CATEGORY_SNS_STATS = 32;
    const CATEGORY_SNS_TEMPLATE = 33;
    
    
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
            self::CATEGORY_SYSTEM_SITE => t('system_site', 'admin'),
            self::CATEGORY_SYSTEM_CACHE => t('system_cache', 'admin'),
            self::CATEGORY_SYSTEM_ATTACHMENTS => t('system_attachments', 'admin'),
        
            self::CATEGORY_DISPLAY => t('display_config_params', 'admin'),
            self::CATEGORY_DISPLAY_TEMPLATE => t('display_template', 'admin'),
            self::CATEGORY_DISPLAY_UI => t('display_ui', 'admin'),
        
            self::CATEGORY_SNS => t('sns_config_params', 'admin'),
            self::CATEGORY_SNS_INTERFACE => t('sns_interface', 'admin'),
            self::CATEGORY_SNS_STATS => t('sns_stats', 'admin'),
            self::CATEGORY_SNS_TEMPLATE => t('sns_template', 'admin'),
        );
    }
    
    public static function flushAllConfig()
    {
        $rows = app()->getDb()->createCommand()
            ->select(array('config_name', 'config_value'))
            ->from(TABLE_CONFIG)
            ->queryAll();
        
        if (empty($rows)) return false;
        
        $rows = CHtml::listData($rows, 'config_name', 'config_value');
        $data = "<?php\nreturn " . var_export($rows, true) . ';';
        $filename = dp('setting.config.php');
        return file_put_contents($filename, $data);
    }

    protected function beforeDelete()
    {
        throw new CException(t('system_config_is_not_allowed_deleted'));
    }
}