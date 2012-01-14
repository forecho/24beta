<?php

/**
 * This is the model class for table "{{comment}}".
 *
 * The followings are the available columns in table '{{comment}}':
 * @property integer $id
 * @property integer $post_id
 * @property string $content
 * @property integer $create_time
 * @property string $create_ip
 * @property integer $up_nums
 * @property integer $down_nums
 * @property integer $report_nums
 * @property integer $user_id
 * @property string $user_name
 * @property string $user_email
 * @property string $user_site
 * @property integer $state
 * @property string $filterContent
 * @property string $createTime
 * @property string $authorName
 * @property string $authorLink
 */
class Comment extends CActiveRecord
{
    
    const STATE_DISABLED = 0;
    const STATE_ENABLED = 1;
    
	/**
	 * Returns the static model of the specified AR class.
	 * @return Comment the static model class
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
		return '{{comment}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
	        array('post_id, content', 'required'),
			array('user_name', 'length', 'max'=>50),
	        array('create_time, up_nums, down_nums, report_nums, state, user_id, post_id', 'numerical', 'integerOnly'=>true),
			array('create_ip', 'length', 'max'=>15),
	        array('user_email, user_site', 'length', 'max'=>250),
	        array('user_email', 'email'),
	        array('user_site', 'url'),
			array('content', 'safe'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
	        'user' => array(self::BELONGS_TO, 'User', 'user_id'),
	        'post' => array(self::BELONGS_TO, 'Post', 'post_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'post_id' => t('post_id'),
			'content' => t('content'),
			'create_time' => t('create_time'),
			'create_ip' => t('create_ip'),
			'up_nums' => t('up_nums'),
			'down_nums' => t('down_nums'),
			'report_nums' => t('report_nums'),
			'user_id' => t('user_id'),
			'user_name' => t('user_name'),
			'user_email' => t('user_email'),
			'user_site' => t('user_site'),
			'state' => t('state'),
		);
	}
	
	public function scopes()
	{
	    return array(
            'recently' => array(
                'order' => 'id desc',
                'limit' => 10,
            ),
        );
	}

	public function getFilterContent()
	{
	    return nl2br(strip_tags($this->content));
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
	    $name = $this->getAuthorName();
	    return $this->user_site ? l($name, $this->user_site, array('target'=>'_blank')) : $name;
	}
	
	public static function fetchList($postid, $page = 1)
	{
	    $postid = (int)$postid;
	    $criteria = new CDbCriteria();
	    $criteria->order = 'id desc';
	    $criteria->limit = param('commentCountOfPage');
	    $offset = ($page - 1) * $criteria->limit;
	    $criteria->offset = $offset;
	    $criteria->addColumnCondition(array(
            'post_id' => $postid,
            'state' => self::STATE_ENABLED,
	    ));
	
	    $comments = Comment::model()->findAll($criteria);
	    return $comments;
	}
	
	public static function fetchHotList($postid, $page = 1)
	{
	    $postid = (int)$postid;
	    $criteria = new CDbCriteria();
	    $criteria->order = 'id desc';
	    $criteria->limit = param('hotCommentCountOfPage');
	    $offset = ($page - 1) * $criteria->limit;
	    $criteria->offset = $offset;
	    $criteria->addColumnCondition(array(
	            'post_id' => $postid,
                'state' => self::STATE_ENABLED)
            )
            ->addCondition('up_nums > ' . param('upNumsOfCommentIsHot'));
	
	    $comments = Comment::model()->findAll($criteria);
	    return $comments;
	}
	
	protected function beforeSave()
	{
	    if ($this->getIsNewRecord()) {
	        $this->up_nums = $this->down_nums = $this->report_nums = 0;
	        $this->create_time = $_SERVER['REQUEST_TIME'];
	        $this->create_ip = request()->getUserHostAddress(); // @todo 此处获取ip地址不精确
	        $this->user_name = strip_tags($this->user_name);
	        $this->user_email = strip_tags($this->user_email);
	        $this->user_site = strip_tags($this->user_site);
	    }
	    return true;
	}
	
	protected function afterSave()
	{
	    $counters = array('comment_nums' => 1);
	    Post::model()->updateCounters($counters, 'id = :pid', array(':pid'=>$this->post_id));
	}
	
	protected function afterDelete()
	{
	    $counters = array('comment_nums' => -1);
	    Post::model()->updateCounters($counters, 'id = :pid', array(':pid'=>$this->post_id));
	    // @todo 此处还需要删除评论的支持及反对记录
	}
	
	
}

