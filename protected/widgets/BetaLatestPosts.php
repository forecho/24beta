<?php
class BetaLatestPosts extends CWidget
{
    const DEFAULT_POST_COUNT = 10;
    const DEFAULT_TITLE_LEN = 40;
    
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
        $this->cid = (int)$this->cid;
        $this->tid = (int)$this->tid;
        $this->allowEmpty = (bool)$this->allowEmpty;
        
        $this->count = (int)$this->count;
        if ($this->count === 0)
            $this->count = self::DEFAULT_POST_COUNT;
        
        $title = trim($this->title);
        if (empty($title))
            $this->title = t('latest_posts');
        
        $this->titleLen = (int)$this->titleLen;
        if ($this->titleLen === 0)
            $this->titleLen = self::DEFAULT_TITLE_LEN;
    }
        
    public function run()
    {
        $models = $this->fetchPosts();
        if (empty($models) && !$this->allowEmpty) return ;
        $this->render('beta_latest_posts', array('models'=>$models));
    }
    
    private function fetchPosts()
    {
        $criteria = new CDbCriteria();
        $criteria->select = array('id', 'category_id', 'topic_id', 'title', 'create_time', 'comment_nums', 'digg_nums', 'visit_nums', 'state');
        $criteria->order = 'create_time desc';
        $criteria->limit = $this->count;
        if ($this->cid)
            $criteria->addColumnCondition(array('category_id'=>$this->cid));
        if ($this->tid)
            $criteria->addColumnCondition(array('topic_id'=>$this->tid));

        $criteria->addColumnCondition(array('t.state'=>POST_STATE_ENABLED));
        
        $models = Post::model()->findAll($criteria);
        return (array)$models;
    }
}