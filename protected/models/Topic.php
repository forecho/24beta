<?php

/**
 * This is the model class for table "{{topic}}".
 *
 * The followings are the available columns in table '{{topic}}':
 * @property integer $id
 * @property integer $parent_id
 * @property string $name
 * @property integer $post_nums
 * @property string $icon
 * @property integer $orderid
 */
class Topic extends CActiveRecord
{
    const ROOT_PARENT_ID = 0;
    
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
	        array('name', 'filter', 'filter'=>'strip_tags'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
	        'postCount' => array(self::STAT, 'Post', 'topic_id'),
	        'subCount' => array(self::STAT, 'Topic', 'parent_id'),
	        'subs' => array(self::HAS_MANY, 'Topic', 'parent_id'),
	        'parent' => array(self::BELONGS_TO, 'Topic', 'parent_id'),
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

	
	public static function fetchRootList()
	{
	    $models = self::fetchSubList(self::ROOT_PARENT_ID);
	    return $models;
	}
	
	public static function fetchSubList($tid)
	{
	    $tid = (int)$tid;
	    $criteria = new CDbCriteria();
	    $criteria->addColumnCondition(array('parent_id'=>$tid));
	    $criteria->order = 'order asc, id asc';
	    $models = self::model()->find($criteria);
	
	    return $models;
	}
	
	protected function beforeSave()
	{
	    if ($this->getIsNewRecord()) {
	        $this->orderid = $this->post_nums = 0;
	    }
	
	    return true;
	}
	
	protected function beforeDelete()
	{
	    if ($this->subCount > 0)
	        $this->addError('name', t('topic_has_subcategory'));
	    if ($this->postCount > 0)
	        $this->addError('name', t('topic_has_post'));
	
	    return $this->hasErrors('name');
	}
}


