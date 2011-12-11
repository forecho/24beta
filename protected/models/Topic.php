<?php

/**
 * This is the model class for table "{{topic}}".
 *
 * The followings are the available columns in table '{{topic}}':
 * @property string $id
 * @property string $parent_id
 * @property string $name
 * @property string $post_nums
 * @property string $icon
 * @property string $orderid
 */
class Topic extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Topic the static model class
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
		return '{{topic}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
	        array('name', 'required'),
	        array('name', 'unique'),
	        array('parent_id, post_nums, orderid', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>50),
			array('icon', 'length', 'max'=>250),
			array('icon', 'file', 'allowEmpty'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, parent_id, name, post_nums, icon, orderid', 'safe', 'on'=>'search'),
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
			'id' => 'Id',
			'parent_id' => 'Parent',
			'name' => 'Name',
			'post_nums' => 'Post Nums',
			'icon' => 'Icon',
			'orderid' => 'Orderid',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);

		$criteria->compare('parent_id',$this->parent_id,true);

		$criteria->compare('name',$this->name,true);

		$criteria->compare('post_nums',$this->post_nums,true);

		$criteria->compare('icon',$this->icon,true);

		$criteria->compare('orderid',$this->orderid,true);

		return new CActiveDataProvider('Topic', array(
			'criteria'=>$criteria,
		));
	}
}