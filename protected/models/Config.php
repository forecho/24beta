<?php

/**
 * This is the model class for table "{{config}}".
 *
 * The followings are the available columns in table '{{config}}':
 * @property integer $id
 * @property string $name
 * @property integer $category_id
 * @property string $config_name
 * @property string $config_value
 * @property string $desc
 */
class Config extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Config the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return TABLE_CONFIG;
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
	        array('name, config_name', 'required'),
	        array('config_name', 'unique'),
	        array('config_name', 'match', 'pattern'=>'/^[a-z][\w\d\_]{4,99}/i', 'message'=>t('config_name_pattern')),
	        array('category_id', 'numerical', 'integerOnly'=>true),
			array('config_name', 'length', 'max'=>100),
			array('config_value, desc', 'safe'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
	        'name' => t('config_nickname'),
			'category_id' => t('config_category'),
			'config_name' => t('config_var_name'),
			'config_value' => t('config_value'),
			'desc' => t('config_description'),
		);
	}


}

