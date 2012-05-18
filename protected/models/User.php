<?php

/**
 * This is the model class for table "{{user}}".
 *
 * The followings are the available columns in table '{{user}}':
 * @property integer $id
 * @property string $email
 * @property string $name
 * @property string $password
 * @property integer $create_time
 * @property string $create_ip
 * @property integer $state
 * @property string $token
 * @property string $createTimeText
 */
class User extends CActiveRecord
{
    public static function states()
    {
        return array(USER_STATE_ENABLED, USER_STATE_UNVERIFY, USER_STATE_FORBIDDEN);
    }
    
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
		return TABLE_USER;
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
	        array('email, name, password', 'required'),
            array('email', 'unique'),
            array('name', 'unique'),
	        array('create_time, state', 'numerical', 'integerOnly'=>true),
			array('email', 'length', 'max'=>100),
	        array('email', 'email'),
			array('name', 'length', 'max'=>50),
			array('password', 'length', 'max'=>32, 'min'=>'5'),
			array('create_ip', 'length', 'max'=>15, 'min'=>7),
    		array('state', 'in', 'range'=>self::states()),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
	        'postCount' => array(self::STAT, 'Post', 'user_id'),
	        'commentCount' => array(self::STAT, 'Comment', 'user_id'),
	        'latestPosts' => array(self::HAS_MANY, 'Post', 'user_id',
                'limit' => 10,
            ),
	        'latestComments' => array(self::HAS_MANY, 'Comment', 'user_id',
                'limit' => 10,
            ),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'email' => t('user_email'),
			'name' => t('user_name'),
			'password' => t('password'),
			'create_time' => t('create_time'),
			'create_ip' => t('create_ip'),
			'state' => t('user_state'),
			'token' => t('user_token'),
		);
	}
	
	public function getCreateTime($format = null)
	{
	    if  (null === $format)
	        $format = param('formatShortDateTime');
	
	    return date($format, $this->create_time);
	}

	public function encryptPassword()
	{
	    $this->password = BetaBase::encryptPassword($this->password);
	}
	
	protected function beforeSave()
	{
	    if ($this->getIsNewRecord()) {
	        $this->create_time = $_SERVER['REQUEST_TIME'];
	        $this->create_ip = request()->getUserHostAddress();
	        $this->state = $this->state && !param('userRequiredEmailVerfiy');
	    }
	    return true;
	}
	
	public function beforeDelete()
	{
	    throw new CException(t('user_not_allow_delete'));
	}

}