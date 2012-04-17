<?php
class PostSearchForm extends CFormModel
{
    public $postid;
    public $author;
    public $keyword;
    public $start_create_time;
    public $end_create_time;
    
    public function rules()
    {
        return array(
            array('postid, start_create_time, end_create_time', 'numerical', 'integerOnly'=>true),
            array('author, keyword', 'filter', 'filter'=>'trim'),
        );
    }
    
    public function attributeLabels()
    {
        return array(
            'postid' => t('postid', 'admin'),
            'author' => t('author', 'admin'),
            'keyword' => t('keyword', 'admin'),
        );
    }
    
    public function search()
    {
        $criteria = new CDbCriteria();
        if ($this->postid)
            $criteria->addColumnCondition(array('t.id'=>$this->postid));
        else {
            if ($this->author)
                $criteria->addColumnCondition(array('t.contributor'=>$author, 't.user_name'=>$this->author), 'OR');
            if ($this->keyword)
                $criteria->addSearchCondition('t.title', $this->keyword);
        }
        $data = $criteria->condition ? AdminPost::fetchList($criteria) : null;
        return $data;
    }
}