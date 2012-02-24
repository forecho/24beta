<?php
class AdminCategory extends Category
{
    /**
     * Returns the static model of the specified AR class.
     * @return AdminCategory the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}