<?php

/**
 * This is the model class for table "{{category}}".
 *
 * The followings are the available columns in table '{{category}}':
 * @property integer $id
 * @property string $name
 * @property integer $post_nums
 * @property integer $orderid
 * @property integer $state
 * @property string $postsUrl
 * @property string $postsLink
 */
class Category extends CActiveRecord
{
    const STATE_SHOW_IN_NAV_MENU = 1;
    const STATE_NOT_SHOW_IN_NAV_MENU = 0;
    
	/**
	 * Returns the static model of the specified AR class.
	 * @return Category the static model class
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
		return TABLE_CATEGORY;
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
	        array('post_nums, orderid, state', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>50),
	        array('name', 'filter', 'filter'=>'strip_tags'),
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
	        'postCount' => array(self::STAT, 'Post', 'category_id'),
	        'subs' => array(self::HAS_MANY, 'Category', 'parent_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => t('category_name'),
			'post_nums' => t('post_nums'),
			'orderid' => t('orderid'),
	        'state' => t('state'),
		);
	}
    
    public static function fetchListObjects()
    {
        $criteria = new CDbCriteria();
        $criteria->order = 'orderid desc, id asc';
        $models = self::model()->findAll($criteria);
        
        return $models;
    }
    
    public static function fetchListArray()
    {
        $cmd = app()->getDb()->createCommand()
            ->from(TABLE_CATEGORY)
            ->order(array('orderid desc', 'id asc'));

        $rows = $cmd->queryAll();
        return $rows;
    }
    
    public static function listData()
    {
        $rows = self::fetchListArray();
        $data = CHtml::listData($rows, 'id', 'name');
        return $data;
    }
    
    public function getPostsUrl()
    {
        return aurl('category/posts', array('id'=>$this->id));
    }
    
    public function getPostsLink($target = '_blank')
    {
        $optionsHtml = empty($target) ? null : array('target'=>$target);
        return l($this->name, $this->getPostsUrl(), $optionsHtml);
    }
    
    protected function beforeSave()
    {
        if ($this->getIsNewRecord()) {
            $this->orderid = (int)$this->orderid;
            $this->post_nums = 0;
        }
        
        $this->state = $this->state ? self::STATE_SHOW_IN_NAV_MENU : self::STATE_NOT_SHOW_IN_NAV_MENU;
        
        return true;
    }
    
    protected function beforeDelete()
    {
        if ($this->subCount > 0)
            $this->addError('name', t('cateogry_has_subcategory'));
        if ($this->postCount > 0)
            $this->addError('name', t('cateogry_has_post'));
        
        return $this->hasErrors('name');
    }
}

