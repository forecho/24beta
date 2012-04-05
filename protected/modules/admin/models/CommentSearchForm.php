<?php
class CommentSearchForm extends CFormModel
{
    public $comment_id;
    public $post_id;
    public $user_id;
    public $user_name;
    public $keyword;
    public $start_create_time;
    public $end_create_time;
    
    public function rules()
    {
        return array(
            array('comment_id, post_id, user_id, start_create_time, end_create_time', 'numerical', 'integerOnly'=>true),
            array('user_name, keyword', 'filter', 'filter'=>'trim'),
        );
    }
    
    public function attributeLabels()
    {
        return array(
            'comment_id' => t('comment_id', 'admin'),
            'post_id' => t('post_id', 'admin'),
            'user_id' => t('comment_user_id', 'admin'),
            'user_name' => t('comment_user_name', 'admin'),
            'keyword' => t('keyword', 'admin'),
            'start_create_time' => t('start_create_time', 'admin'),
            'end_create_time' => t('end_create_time', 'admin'),
        );
    }
    
    public function search()
    {
        $criteria = new CDbCriteria();
        if ($this->comment_id) {
            if ($this->comment_id)
                $criteria->addColumnCondition(array('t.id'=>$this->comment_id));
        } else {
            if ($this->post_id)
                $criteria->addColumnCondition(array('t.post_id'=>$this->post_id));
            if ($this->user_id)
                $criteria->addColumnCondition(array('t.user_id'=>$this->user_id));
            if ($this->user_name)
                $criteria->addColumnCondition(array('t.user_name'=>$this->user_name));
            if ($this->keyword)
                $criteria->addSearchCondition('t.content', $this->keyword);
            
            if ($this->start_create_time || $this->end_create_time) {
                $criteria->addCondition(array('and', 't.create_time > :starttime', 't.create_time < :endtime'));
                $starttime = (int)$this->start_create_time ? strtotime($this->start_create_time) : 0;
                $endtime = (int)$this->end_create_time ? strtotime($this->end_create_time) : $_SERVER['REQUEST_TIME'];
                $params = array(':starttime' => $starttime, ':endtime' => $endtime);
                $criteria->params = array_merge($criteria->params, $params);
            }
        }
        $data = $criteria->condition ? AdminComment::fetchList($criteria) : null;
        return $data;
    }
}