<?php

/**
 * This is the model class for table "{{Special}}".
 *
 * The followings are the available columns in table '{{Special}}':
 * @property integer $id
 * @property string $token
 * @property string $name
 * @property string $thumbnail
 * @property integer $create_time
 * @property integer $state
 * @property string $desc
 * @property string $url
 * @property string $nameLink
 * @property string $thumbnailUrl
 * @property string $thumbnailHtml
 * @property string $thumbnailLink
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
		return TABLE_SPECIAL;
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
			array('create_time, state', 'numerical', 'integerOnly'=>true),
		    array('state', 'in', 'range'=>array(SPECIAL_STATE_ENABLED, SPECIAL_STATE_DISABLED)),
			array('token, name', 'length', 'max'=>100),
			array('desc, thumbnail', 'length', 'max'=>250),
			array('desc', 'safe'),
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
		    'state' => t('state'),
		    'thumbnail' => t('thumbnail'),
		);
	}

	public function getUrl()
	{
	    return aurl('special/show', array('id'=>$this->id));
	}
	
	public function getNameLink($target = '_blank')
	{
	    return l($this->name, $this->getUrl(), array('target'=>$target));
	}
	
	public function getThumbnailUrl()
	{
	    $thumbnail = $this->thumbnail;
	    if (empty($thumbnail))
	        return '';
	    
	    $pos = strpos($thumbnail, 'http://');
	    if ($pos === 0)
	        $url = $thumbnail;
	    elseif ($pos === false)
	        $url  = fbu($thumbnail);
	    else
	        $url = '';
	    
	    return $url;
	}
	
	public function getThumbnailHtml()
	{
	    $url = $this->getThumbnailUrl();
	    if (empty($url))
	        $html = '';
	    else {
	        $html = image($url, $this->name, array('title'=>$this->name));
	    }
	    
	    return $html;
	}
	
	public function getThumbnailLink($target = '_blank')
	{
	    $image = $this->getThumbnailHtml();
	    if (empty($image))
	        $html = '';
	    else {
	        $html = l($image, $this->getUrl(), array('target'=>$target));
	    }
	    
	    return $html;
	}
	
	public static function fetchEnabledList(CDbCriteria $criteria = null, $pages = true)
	{
	    static $defaultSize = 12;
	    
	    if ($criteria === null)
	        $criteria = new CDbCriteria();
	
	    $criteria->addColumnCondition(array('t.state'=>SPECIAL_STATE_ENABLED));
	    $criteria->order = 'create_time desc';
	    if ($pages) {
	        $limit = ($criteria->limit <= 0) ? $defaultSize : $criteria->limit;
	        $pages = new CPagination(self::model()->count($criteria));
	        $pages->setPageSize($limit);
	        $pages->applyLimit($criteria);
	        $data['pages'] = $pages;
	    }
	
	    $models = self::model()->findAll($criteria);
	    if (empty($models))
	        $data = array();
	    else
	        $data['models'] = $models;
	    
	    return $data;
	}

    protected function beforeSave()
    {
        if ($this->getIsNewRecord()) {
            $this->create_time = $_SERVER['REQUEST_TIME'];
            $this->state = $this->state ? SPECIAL_STATE_ENABLED : SPECIAL_STATE_DISABLED;
            $this->token = strip_tags(trim($this->token));
            $this->name = strip_tags(trim($this->name));
        }
        
        return true;
    }
    
    protected function beforeDelete()
    {
        try {
            $result = $this->getDbConnection()->createCommand()
                ->delete('{{special2post}}', 'special_id = :specialid', array(':specialid'=>$this->id));
            
            return true;
        }
        catch (Exception $e) {
            return false;
        }
    }
    
    protected function afterFind()
    {
        $this->name = strip_tags(trim($this->name));
        $this->token = strip_tags(trim($this->token));
        $this->thumbnail = strip_tags(trim($this->thumbnail));
    }
}






