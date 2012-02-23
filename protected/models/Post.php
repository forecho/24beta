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
 * @property integer $digg_nums
 * @property integer $visit_nums
 * @property integer $user_id
 * @property string $user_name
 * @property string $source
 * @property string $tags
 * @property integer $state
 * @property integer $istop
 * @property integer $disable_comment
 * @property string $thumbnail
 * @property string $summary
 * @property string $content
 * @property integer $contributor_id
 * @property string $contributor
 * @property string $contributor_site
 * @property string $contributor_email
 * @property string $filterContent
 * @property string $crateTime
 * @property string $authorName
 * @property string $contributorName
 * @property string $contributorLink
 * @property float $rating
 * @property string $sourceLink
 * @property string $url
 * @property string $absoluteUrl
 * @property string $relativeUrl
 * @property string $titleLink
 * @property string $postToolbar
 * @property string $subTitle
 * @property string $tagArray
 * @property string $tagText
 * @property string $tagLinks
 * @property string $thumbnailUrl
 * @property string $categoryLink
 * @property string $topicLink
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
	        array('title, summary, content', 'required'),
	        array('category_id, topic_id, score_nums, comment_nums, digg_nums, visit_nums, user_id, create_time, state, istop, disable_comment, contributor_id', 'numerical', 'integerOnly'=>true),
			array('thumbnail, source, title, tags, contributor_site, contributor_email', 'length', 'max'=>250),
			array('create_ip', 'length', 'max'=>15),
			array('user_name, contributor', 'length', 'max'=>50),
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
			'digg_nums' => t('digg_nums'),
			'visit_nums' => t('visit_nums'),
			'user_id' => t('user'),
			'user_name' => t('user_name'),
	        'source' => t('source'),
			'tags' => t('tags'),
			'state' => t('state'),
			'istop' => t('istop'),
		    'disable_comment' => t('disable_comment'),
			'thumbnail' => t('thumbnail'),
			'summary' => t('summary'),
			'content' => t('content'),
		    'contributor_id' => t('contributor_id'),
		    'contributor' => t('contributor'),
		    'contributor_site' => t('contributor_site'),
		    'contributor_email' => t('contributor_email'),
		);
	}
	
	public function scopes()
	{
	    return array(
            'published' => array(
                'condition' => 'state > 0',
            ),
            'recently' => array(
                'condition' => 'state > 0',
                'order' => 'id desc',
                'limit' => 10,
            ),
	    );
	}
	
	public function getFilterContent()
	{
	    // @todo filter content
	    return nl2br(strip_tags($this->content, '<b><div><p><strong><img><i><a><br>'));
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
	
	public function getContributorName()
	{
	    return (empty($this->contributor)) ? t('guest_name') : $this->contributor;
	}
	
	public function getContributorLink()
	{
	    $name = $this->getContributorName();
	    return $this->contributor_site ? l($name, $this->contributor_site, array('target'=>'_blank')) : $name;
	}
	
	public function getRating()
	{
	    $nums = $this->score_nums ? $this->score_nums : 1;
	    return sprintf('%.1f', $this->score / $nums);
	}
	
	public function getSourceLink()
	{
	    if (empty($this->source)) return '';
	    
	    if (strpos($this->source, 'http://') === false && strpos($this->source, 'https://') === false)
	        $source = $this->source;
	    else
	        $source = l($this->source, $this->source, array('target'=>'_blank', 'class'=>'post-source'));
	    
	    return $source;
	}
	
	public function getUrl($absolute = true)
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
	
	public function getTitleLink($len = 0, $target = '_blank')
	{
	    $len = (int)$len;
	    if ($this->istop == BETA_YES)
	        $this->title = '[' . t('istop') . ']' . $this->title;
	    $title = ($len === 0) ? $this->title : $this->getSubTitle($len);
	    if ($this->istop == BETA_YES)
	        $title = '<strong>' . $title . '</strong>';
	    return l($title, $this->getUrl(), array('class'=>'post-title', 'target'=>$target));
	}
	
	public function getPostToolbar()
	{
	    // @todo 此处authorName最终应该为authorLink
	    return array('{comment_nums}'=>$this->comment_nums, '{score_nums}'=>$this->score_nums, '{visit}'=>$this->visit_nums, '{digg}'=>$this->digg_nums);
	}
	
	public function getSubTitle($len = 40)
	{
	    return mb_strimwidth($this->title, 0, $len, '...', app()->charset);
	}
	
	
	protected function beforeSave()
	{
	    if ($this->getIsNewRecord()) {
	        $this->title = strip_tags($this->title);
	        $this->create_time = $_SERVER['REQUEST_TIME'];
	        $this->create_ip = request()->getUserHostAddress();
	        $this->source = strip_tags(trim($this->source));
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
	        $content = strip_tags($this->content, param('summaryHtmlTags'));
	        $this->summary = mb_substr($content, 0, param('subSummaryLen'), app()->charset);
	    }
	    else
	        $this->summary = strip_tags($this->summary, param('summaryHtmlTags'));
	}
	
	/**
	 * 获取标签的数组形式
	 * @return array
	 */
	public function getTagArray()
	{
	    return Tag::filterTagsArray($this->tags);
	}
	
	public function getTagText()
	{
	    $tagsArray = $this->getTagArray();
	     
	    return (empty($tagsArray)) ? '' : join(',', $tagsArray);
	}
	
	public function getTagLinks($operator = '', $target = '_blank', $class='beta-tag')
	{
	    $tags = $this->getTagArray();
	    if (empty($tags)) return '';
	
	    foreach ($tags as $tag)
	        $data[] = l($tag, aurl('tag/posts', array('name'=>urlencode($tag))), array('target'=>$target, 'class'=>$class));
	    
	    return t('tags') . ':' . implode($operator, $data);
	}

	public function getThumbnailUrl()
	{
	    $url = $this->thumbnail;
	    if (empty($url)) {
	        // @todo 此处读取文章中第一个图片作为缩略图。
	    }
	    
	    if ($url) {
	        $pos = strpos($this->thumbnail, 'http://');
	        if ($pos === false)
	            $url = fbu($this->thumbnail);
	        elseif ($pos === 0)
	            $url = $this->thumbnail;
	    }
	    else
	        $url = '';
	    
	    
	    return $url;
	}

	public function getCategoryLink($target = '_blank')
	{
	    if ($this->category)
	        return $this->category->getPostsLink($target);
	    else
	        return '';
	}
	
	public function getTopicLink()
	{
	    if ($this->topic)
	        return $this->topic->getPostsLink($target);
	    else
	        return '';
	}
	
	public function getShowExtraInfo()
	{
	    return t('post_show_extra', 'main', array('{author}'=>$this->authorName, '{time}'=>$this->createTime, '{visit}'=>$this->visit_nums, '{digg}'=>$this->digg_nums));
	}
}





