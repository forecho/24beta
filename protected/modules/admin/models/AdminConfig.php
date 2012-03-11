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
            self::CATEGORY_CUSTOM => 0,
            self::CATEGORY_SYSTEM => 0,
            self::CATEGORY_DISPLAY => 0,
            self::CATEGORY_UI => 0,
            self::CATEGORY_PERFORMANCE => 0,
            self::CATEGORY_SNS => 0,
        );
    }
}