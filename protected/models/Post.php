<?php

/**
 * This is the model class for table "{{post}}".
 *
 * The followings are the available columns in table '{{post}}':
 * @property integer $id
 * @property integer $category_id
 * @property integer $topic_id
 * @property string $title
 * @property string $content
 * @property integer $create_time
 * @property string $create_ip
 * @property integer $score
 * @property integer $score_nums
 * @property string $comment_nums
 * @property integer $user_id
 * @property string $user_name
 * @property string $source
 * @property string $tags
 * @property integer $state
 */
class Post extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Post the static model class
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
		return '{{post}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
	        array('title, content', 'required'),
	        array('category_id, topic_id, score_nums, comment_nums, user_id, create_time, state', 'numerical', 'integerOnly'=>true),
			array('source, title, tags', 'length', 'max'=>250),
			array('create_ip', 'length', 'max'=>15),
			array('user_name', 'length', 'max'=>50),
			array('content', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, category_id, topic_id, title, content, create_time, create_ip, score, score_nums, comment_nums, user_id, user_name, source, tags, state', 'safe', 'on'=>'search'),
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
			'category_id' => 'Category',
			'topic_id' => 'Topic',
			'title' => 'Title',
			'content' => 'Content',
			'create_time' => 'Create Time',
			'create_ip' => 'Create Ip',
			'score' => 'Score',
			'score_nums' => 'Score Nums',
			'comment_nums' => 'Comment Nums',
			'user_id' => 'User',
			'user_name' => 'User Name',
	        'source' => 'Source',
			'tags' => 'Tags',
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

		$criteria->compare('category_id',$this->category_id,true);

		$criteria->compare('topic_id',$this->topic_id,true);

		$criteria->compare('title',$this->title,true);

		$criteria->compare('content',$this->content,true);

		$criteria->compare('create_time',$this->create_time,true);

		$criteria->compare('create_ip',$this->create_ip,true);

		$criteria->compare('score',$this->score,true);

		$criteria->compare('score_nums',$this->score_nums,true);

		$criteria->compare('comment_nums',$this->comment_nums,true);

		$criteria->compare('user_id',$this->user_id,true);

		$criteria->compare('user_name',$this->user_name,true);

		$criteria->compare('tags',$this->tags,true);

		$criteria->compare('state',$this->state,true);

		return new CActiveDataProvider('Post', array(
			'criteria'=>$criteria,
		));
	}
}