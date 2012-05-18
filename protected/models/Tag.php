<?php

/**
 * This is the model class for table "{{tag}}".
 *
 * The followings are the available columns in table '{{tag}}':
 * @property integer $id
 * @property string $name
 * @property integer $post_nums
 */
class Tag extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Tag the static model class
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
		return TABLE_TAG;
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
	        array('post_nums', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>50),
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
			'name' => t('tag_name'),
			'post_nums' => t('post_nums'),
		);
	}
	
	public static function filterTagsArray($tags)
	{
	    if (empty($tags)) return array();
	    
	    $tags = str_replace('，', ',', $tags);
	    $tags = explode(',', $tags);
	    $tagsArray = array();
	    foreach ((array)$tags as $tag) {
	        if (!empty($tag))
    	        $tagsArray[] = strip_tags(trim($tag));
	    }
	    
	    unset($tags, $tag);
	    return $tagsArray;
	}
	

	public static function savePostTags($postid, $tags)
	{
	    $postid = (int)$postid;
	    if (0 === $postid || empty($tags))
	        return false;
	
	    if (is_string($tags))
	        $tags = self::filterTagsArray($tags);
	
	    $count = 0;
	    foreach ((array)$tags as $v) {
	        $model = self::model()->findByAttributes(array('name'=>$v));
	        if ($model === null) {
	            $model = new Tag();
	            $model->name = $v;
	            $model->post_nums = 1;
	            if ($model->save()) $count++;
	        }
	        
	        $row = app()->getDb()->createCommand()
    	        ->select(TABLE_POST_TAG)
    	        ->where(array('and', 'post_id = :postid', 'tag_id = :tagid', array(':postid'=>$postid, ':tagid'=>$model->id)))
    	        ->queryScalar();
	            
            if ($row === false) {
                $columns = array('post_id'=>$postid, 'tag_id'=>$model->id);
                $count = app()->getDb()->createCommand()->insert('{{post2tag}}', $columns);
                if ($count > 0) {
	                $model->post_nums = $model->post_nums + 1;
    	            $model->save(true, array('post_nums'));
                }
            }
	        unset($model);
	    }
	    return $count;
	}
}