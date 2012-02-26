<?php
/**
 * @property string $editUrl
 * @property string $deleteUrl
 * @property string $verifyUrl
 */
class AdminPost extends Post
{
    /**
     * Returns the static model of the specified AR class.
     * @return AdminPost the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
    
    public function getInfoUrl()
    {
        return url('admin/post/info', array('id'=>$this->id));
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
        $criteria->limit = param('adminPostCountOfPage');
         
        if ($sort) {
            $sort  = new CSort('AdminPost');
            $sort->defaultOrder = 'id desc';
            $sort->applyOrder($criteria);
        }
         
        if ($pages) {
            $count = self::model()->count($criteria);
            $pages = new CPagination($count);
            $pages->setPageSize($criteria->limit);
            $pages->applyLimit($criteria);
        }
         
        $models = AdminPost::model()->findAll($criteria);
         
        $data = array(
            'models' => $models,
            'sort' => $sort,
            'pages' => $pages,
        );
         
        return $data;
    }

    public function getEditUrl()
    {
        return l(t('edit', 'admin'), url('admin/post/create', array('id'=>$this->id)));
    }

    public function getDeleteUrl()
    {
        return l(t('delete', 'admin'), url('admin/post/delete', array('id'=>$this->id)));
    }

    public function getVerifyUrl()
    {
        $text = t(($this->state == AdminPost::STATE_DISABLED) ? 'setshow' : 'sethide', 'admin');
        return l($text, url('admin/post/setVerify', array('id'=>$this->id)), array('class'=>'set-verify'));
    }
}