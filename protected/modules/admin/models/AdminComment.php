<?php
/**
 * @property string $editUrl
 * @property string $deleteUrl
 * @property string $verifyUrl
 */
class AdminComment extends Comment
{
    /**
     * Returns the static model of the specified AR class.
     * @return AdminComment the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
    
    public function getInfoUrl()
    {
        return url('admin/comment/info', array('id'=>$this->id));
    }
    
    public function getAdminTitleLink($target = 'main')
    {
	    if ($this->istop == BETA_YES)
	        $title = '<strong>[' . t('istop') . ']' . $this->title . '</strong>';
	    else
	        $title = $this->title;
	    
	    return l($title, $this->getInfoUrl(), array('class'=>'post-title', 'target'=>$target));
    }
    
    public static function fetchList($criteria = null, $sort = true, $pages = true)
    {
        $criteria = ($criteria === null) ? new CDbCriteria() : $criteria;
        if ($criteria->limit < 0)
            $criteria->limit = param('adminCommentCountOfPage');
         
        if ($sort) {
            $sort  = new CSort(__CLASS__);
            $sort->defaultOrder = 't.id desc';
            $sort->applyOrder($criteria);
        }
         
        if ($pages) {
            $count = self::model()->count($criteria);
            $pages = new CPagination($count);
            $pages->setPageSize($criteria->limit);
            $pages->applyLimit($criteria);
        }
         
        $models = self::model()->with('post')->findAll($criteria);
         
        $data = array(
            'models' => $models,
            'sort' => $sort,
            'pages' => $pages,
        );
         
        return $data;
    }

    public function getEditUrl()
    {
        return l(t('edit', 'admin'), url('admin/comment/create', array('id'=>$this->id)));
    }

    public function getDeleteUrl()
    {
        return l(t('delete_comment', 'admin'), url('admin/comment/delete', array('id'=>$this->id)), array('class'=>'set-delete'));
    }

    public function getVerifyUrl()
    {
        $text = t(($this->state == COMMENT_STATE_DISABLED) ? 'show_comment' : 'hide_comment', 'admin');
        return l($text, url('admin/comment/setVerify', array('id'=>$this->id)), array('class'=>'set-verify'));
    }

    public function getRecommendUrl()
    {
        $text = t(($this->recommend == BETA_NO) ? 'set_recommend_comment' : 'cancel_recommend_comment', 'admin');
        return l($text, url('admin/comment/setRecommend', array('id'=>$this->id)), array('class'=>'set-recommend'));
    }
}