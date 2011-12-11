<?php

/**
 * This is the model class for table "{{comment}}".
 *
 * The followings are the available columns in table '{{comment}}':
 * @property integer $id
 * @property integer $post_id
 * @property string $content
 * @property integer $create_time
 * @property string $create_ip
 * @property integer $up_nums
 * @property integer $down_nums
 * @property integer $report_nums
 * @property integer $user_id
 * @property string $user_name
 * @property string $user_email
 * @property string $user_site
 * @property integer $state
 */
class Comment extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Comment the static model class
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
		return '{{comment}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
	        array('post_id, content', 'required'),
			array('post_id, user_id', 'length', 'max'=>19),
			array('user_name', 'length', 'max'=>50),
	        array('create_time, up_nums, down_nums, report_nums, state', 'numerical', 'integerOnly'=>true),
			array('create_ip', 'length', 'max'=>15),
	        array('user_email, user_site', 'length', 'max'=>250),
	        array('user_email', 'email'),
			array('content', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, post_id, content, create_time, create_ip, up_nums, down_nums, report_nums, user_id, user_name, user_email, user_site, state', 'safe', 'on'=>'search'),
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
			'post_id' => 'Post',
			'content' => 'Content',
			'create_time' => 'Create Time',
			'create_ip' => 'Create Ip',
			'up_nums' => 'Up Nums',
			'down_nums' => 'Down Nums',
			'report_nums' => 'Report Nums',
			'user_id' => 'User Id',
			'user_name' => 'User Name',
			'user_email' => 'User Email',
			'user_site' => 'User Site',
			'state' => 'State',
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

		$criteria->compare('post_id',$this->post_id,true);

		$criteria->compare('content',$this->content,true);

		$criteria->compare('user_id',$this->user_id,true);

		$criteria->compare('user_name',$this->user_name,true);

		$criteria->compare('create_time',$this->create_time,true);

		$criteria->compare('create_ip',$this->create_ip,true);

		$criteria->compare('up_nums',$this->up_nums,true);

		$criteria->compare('down_nums',$this->down_nums,true);

		$criteria->compare('report_nums',$this->report_nums,true);

		$criteria->compare('state',$this->state,true);

		return new CActiveDataProvider('Comment', array(
			'criteria'=>$criteria,
		));
	}
}