<?php

/**
 * This is the model class for table "{{category}}".
 *
 * The followings are the available columns in table '{{category}}':
 * @property integer $id
 * @property integer $parent_id
 * @property string $name
 * @property integer $post_nums
 * @property integer $orderid
 * @property string $postsUrl
 * @property string $postsLink
 */
class Category extends CActiveRecord
{
    const ROOT_PARENT_ID = 0;
    
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
		return '{{category}}';
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
	        'subCount' => array(self::STAT, 'Category', 'parent_id'),
	        'subs' => array(self::HAS_MANY, 'Category', 'parent_id'),
	        'parent' => array(self::BELONGS_TO, 'Category', 'parent_id'),
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
			'orderid' => 'Orderid',
		);
	}

    public static function fetchRootList()
    {
        $models = self::fetchSubList(self::ROOT_PARENT_ID);
        return $models;
    }
    
    public static function fetchSubList($pid)
    {
        $pid = (int)$pid;
        $criteria = new CDbCriteria();
        $criteria->addColumnCondition(array('parent_id'=>$pid));
        $criteria->order = 'order asc, id asc';
        $models = self::model()->find($criteria);
        
        return $models;
    }
    
    public function getPostsUrl()
    {
        return aurl('category/posts', array('id'=>$this->id));
    }
    
    
    public function getPostsLink($target = '_blank')
    {
        return t('category') . '&nbsp;' . l($this->name, $this->getPostsUrl(), array('target'=>$target));
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
            $this->addError('name', t('cateogry_has_subcategory'));
        if ($this->postCount > 0)
            $this->addError('name', t('cateogry_has_post'));
        
        return $this->hasErrors('name');
    }
}

