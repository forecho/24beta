<?php

/**
 * This is the model class for table "{{User}}".
 *
 * The followings are the available columns in table '{{User}}':
 * @property string $id
 * @property string $username
 * @property string $password
 * @property string $nick_name
 * @property string $display_name
 * @property string $email
 * @property string $homepage
 * @property string $avatar
 * @property string $activation_key
 * @property string $create_time
 * @property string $create_ip
 * @property string $login_time
 * @property string $login_ip
 * @property string $login_nums
 * @property string $status
 */
class User extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return User the static model class
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
		return '{{User}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('username, nick_name', 'length', 'max'=>45),
			array('password', 'length', 'max'=>64),
			array('display_name, activation_key', 'length', 'max'=>100),
			array('email', 'length', 'max'=>255),
			array('homepage, avatar', 'length', 'max'=>250),
			array('create_time, login_time, status', 'length', 'max'=>10),
			array('create_ip, login_ip', 'length', 'max'=>15),
			array('login_nums', 'length', 'max'=>19),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, username, password, nick_name, display_name, email, homepage, avatar, activation_key, create_time, create_ip, login_time, login_ip, login_nums, status', 'safe', 'on'=>'search'),
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
			'username' => 'Username',
			'password' => 'Password',
			'nick_name' => 'Nick Name',
			'display_name' => 'Display Name',
			'email' => 'Email',
			'homepage' => 'Homepage',
			'avatar' => 'Avatar',
			'activation_key' => 'Activation Key',
			'create_time' => 'Create Time',
			'create_ip' => 'Create Ip',
			'login_time' => 'Login Time',
			'login_ip' => 'Login Ip',
			'login_nums' => 'Login Nums',
			'status' => 'Status',
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

		$criteria->compare('username',$this->username,true);

		$criteria->compare('password',$this->password,true);

		$criteria->compare('nick_name',$this->nick_name,true);

		$criteria->compare('display_name',$this->display_name,true);

		$criteria->compare('email',$this->email,true);

		$criteria->compare('homepage',$this->homepage,true);

		$criteria->compare('avatar',$this->avatar,true);

		$criteria->compare('activation_key',$this->activation_key,true);

		$criteria->compare('create_time',$this->create_time,true);

		$criteria->compare('create_ip',$this->create_ip,true);

		$criteria->compare('login_time',$this->login_time,true);

		$criteria->compare('login_ip',$this->login_ip,true);

		$criteria->compare('login_nums',$this->login_nums,true);

		$criteria->compare('status',$this->status,true);

		return new CActiveDataProvider('User', array(
			'criteria'=>$criteria,
		));
	}
}