<?php

/**
 * This is the model class for table "{{post}}".
 *
 * The followings are the available columns in table '{{post}}':
 * @property integer $id
 * @property integer $category_id
 * @property integer $topic_id
 * @property string $title
 * @property integer $create_time
 * @property string $create_ip
 * @property integer $score
 * @property integer $score_nums
 * @property integer $comment_nums
 * @property integer $user_id
 * @property string $user_name
 * @property string $source
 * @property string $tags
 * @property integer $state
 * @property string $summary
 * @property string $content
 * @property string $filterContent
 * @property string $crateTime
 * @property string $authorName
 * @property string $authorLink
 * @property float $rating
 * @property string $sourceLink
 * @property string $url
 * @property string $absoluteUrl
 * @property string $relativeUrl
 * @property string $titleLink
 */
class Post extends CActiveRecord
{
    const STATE_DISABLED = 0;
    const STATE_ENABLED = 10;
    const STATE_TOP = 20;
    
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
			array('summary, content', 'safe'),
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
	        'category'=>array(self::BELONGS_TO, 'Category', 'category_id'),
	        'topic'=>array(self::BELONGS_TO, 'Topic', 'topic_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'category_id' => t('category'),
			'topic_id' => t('topic'),
			'title' => t('title'),
			'create_time' => t('create_time'),
			'create_ip' => t('create_ip'),
			'score' => t('score'),
			'score_nums' => t('score_nums'),
			'comment_nums' => t('comment_nums'),
			'user_id' => t('user'),
			'user_name' => t('user_name'),
	        'source' => t('source'),
			'tags' => t('tags'),
			'state' => t('state'),
			'summary' => t('summary'),
			'content' => t('content'),
		);
	}

	public function getFilterContent()
	{
	    return nl2br(strip_tags($this->content, '<b><div><p><strong><img><i><a>'));
	}
	
	public function getCreateTime($format = null)
	{
	    if  (null === $format)
	        $format = param('formatShortDateTime');
	
	    return date($format, $this->create_time);
	}
	
	public function getAuthorName()
	{
	    static $name;
	
	    if (null !== $name) return $name;
	
	    if ($this->user_name)
	        $name = $this->user_name;
	    elseif ($this->user_id)
	    $name = $this->user->name;
	    else
	        $name = t('guest_name');
	
	    return $name;
	}
	
	public function getAuthorLink()
	{
	    // @todo 暂时没用 添加 postmeta表后修改
	    $name = $this->getAuthorName();
	    return $this->user_site ? l($name, $this->user_site, array('target'=>'_blank')) : $name;
	}
	
	public function getRating()
	{
	    $nums = $this->score_nums ? $this->score_nums : 1;
	    return sprintf('%.1f', $this->score / $nums);
	}
	
	public function getSourceLink()
	{
	    if (strpos($this->source, 'http://') === false && strpos($this->source, 'https://') === false)
	        return $this->source;
	    else
	        return l($this->source, $this->source, array('target'=>'_blank', array('class'=>'post-source')));
	}
	
	public function getUrl($absolute = false)
	{
	    return $absolute ? aurl('post/show', array('id'=>$this->id)) : url('post/show', array('id'=>$this->id));
	}
	
	public function getAbsoluteUrl()
	{
	    return $this->getUrl(true);
	}
	
	public function getRelativeUrl()
	{
	    return $this->getUrl(false);
	}
	
	public function getTitleLink($target = '_blank')
	{
	    return l($this->title, $this->getUrl(), array('class'=>'post-title', 'target'=>$target));
	}
	
	protected function beforeSave()
	{
	    if ($this->getIsNewRecord()) {
	        $this->title = strip_tags($this->title);
	        $this->create_time = $_SERVER['REQUEST_TIME'];
	        $this->create_ip = request()->getUserHostAddress();
	        $this->source = strip_tags(trim($this->source));
	        if (empty($this->summary))
	            $this->summary = mb_substr($this->content, 0, param('subSummaryLen'), app()->charset);
	    }
	    return true;
	}
	
	protected function afterSave()
	{
	    $counters = array('post_nums' => 1);
	    Category::model()->updateCounters($counters, 'id = :cid', array(':cid'=>$this->category_id));
	    Topic::model()->updateCounters($counters, 'id = :tid', array(':tid'=>$this->topic_id));
	    
	    // @todo 此处还要处理tag的保存
	}
	
	protected function afterDelete()
	{
	    $counters = array('post_nums' => -1);
	    Category::model()->updateCounters($counters, 'id = :cid', array(':cid'=>$this->category_id));
	    Topic::model()->updateCounters($counters, 'id = :tid', array(':tid'=>$this->topic_id));
	    
	    $comments = Comment::model()->findAll('post_id = :pid', array(':pid'=>$this->id));
	    foreach ($comments as $c) $c->delete();
	    
	    app()->db->createCommand()
	        ->delete('{{post2tag}}', 'post_id = :pid', array(':pid'=>$this->id));
	    
	    // @todo 此处删除文章后对应的图片也应该删除
	}

	protected function afterFind()
	{
	    if (empty($this->summary)) {
	        $content = strip_tags($this->content);
	        $this->summary = mb_substr($content, 0, param('subSummaryLen'), app()->charset);
	    }
	    else
	        $this->summary = strip_tags($this->summary, param('summaryHtmlTags'));
	}
}


