<?php

/**
 * This is the model class for table "{{Special}}".
 *
 * The followings are the available columns in table '{{Special}}':
 * @property integer $id
 * @property string $token
 * @property string $name
 * @property string $desc
 * @property integer $create_time
 */
class Special extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Special the static model class
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
		return '{{Special}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
		    array('token, name', 'required'),
		    array('token, name', 'unique'),
			array('create_time', 'numerical', 'integerOnly'=>true),
			array('token, name', 'length', 'max'=>100),
			array('desc', 'length', 'max'=>250),
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
		    'posts' => array(self::MANY_MANY, 'Post', '{{special2post}}(special_id, post_id)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'token' => t('special_token'),
			'name' => t('special_name'),
			'desc' => t('special_desc'),
			'create_time' => t('create_time'),
		);
	}

}