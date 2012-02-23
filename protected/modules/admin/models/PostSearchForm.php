<?php
class PostSearchForm extends CFormModel
{
    public $postid;
    public $author;
    public $keyword;
    
    public function rules()
    {
        return array(
            array('postid', 'numerical', 'integerOnly'=>true),
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
            $criteria->addColumnCondition(array('id'=>$this->postid));
        if ($this->author)
            $criteria->addColumnCondition(array('contributor'=>$author, 'user_name'=>$this->author), 'OR');
        if ($this->keyword)
            $criteria->addSearchCondition('title', $this->keyword);
         
        $data = $criteria->condition ? AdminPost::fetchList($criteria) : null;
        return $data;
    }
}