<?php
class BetaSpecialPosts extends CWidget
{
    const DEFAULT_POST_COUNT = 10;
    const DEFAULT_DAYS = 7;
    const DEFAULT_TITLE_LEN = 40;
    
    /**
     * specail token
     * @var string
     */
    public $token;
    
    /**
     * posts count
     * @var integer
     */
    public $count;
    
    /**
     * category id
     * @var integer
     */
    public $cid;
    
    /**
     * topic id
     * @var integer
     */
    public $tid;
    
    /**
     * post list title
     * @var string
     */
    public $title;
    
    /**
     * title sub len
     * @var integer
     */
    public $titleLen;
    
    /**
     * 如果内容为空的话是否显示
     * @var boolean
     */
    public $allowEmpty = false;
    
    public function init()
    {
        if (empty($this->token))
            throw new CException(t('special_token_is_null'));
            
        $this->cid = (int)$this->cid;
        $this->tid = (int)$this->tid;
        $this->allowEmpty = (bool)$this->allowEmpty;
        
        $this->count = (int)$this->count;
        if ($this->count === 0)
            $this->count = self::DEFAULT_POST_COUNT;
        
        $this->titleLen = (int)$this->titleLen;
        if ($this->titleLen === 0)
            $this->titleLen = self::DEFAULT_TITLE_LEN;
    }
        
    public function run()
    {
        $model = $this->fetchPosts();
        if (empty($model->posts) && !$this->allowEmpty) return ;
        $this->render('beta_special_posts', array('model'=>$model));
    }
    
    private function fetchPosts()
    {
        $with['select'] = array('id', 'category_id', 'topic_id', 'title', 'create_time', 'comment_nums', 'digg_nums', 'visit_nums', 'state', 'thumbnail');
        $with['order'] = 'posts.create_time desc, posts.id desc';
        $with['limit'] = $this->count;
        $condition = 'posts.state = ' . Post::STATE_DISABLED;
        if ($this->cid)
            $condition .= ' and posts.category_id = ' . $this->cid;
        if ($this->tid)
            $condition .= ' and posts.topic_id = ' . $this->tid;
        
        $with['condition'] = $condition;
        
        $model = Special::model()->with(array('posts'=>$with))->findByAttributes(array('token'=>$this->token));
        return $model;
    }
}

