<?php
/**
 * @property string $infoUrl
 * @property string $editUrl
 * @property string $deleteUrl
 * @property string $verifyUrl
 * @property string $adminTitleLink
 * @property string $verifyUlr
 * @property string $hottestUrl
 * @property string $recommendUrl
 * @property string $homeshowUrl
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
        if ($criteria->limit < 0)
            $criteria->limit = param('adminPostCountOfPage');
        
        if ($sort) {
            $sort  = new CSort(__CLASS__);
            $sort->defaultOrder = 'id desc';
            $sort->applyOrder($criteria);
        }
         
        if ($pages) {
            $count = self::model()->count($criteria);
            $pages = new CPagination($count);
            $pages->setPageSize($criteria->limit);
            $pages->applyLimit($criteria);
        }

        $models = self::model()->findAll($criteria);
         
        $data = array(
            'models' => $models,
            'sort' => $sort,
            'pages' => $pages,
        );
         
        return $data;
    }

    public function getEditUrl()
    {
        return l(t('edit', 'admin'), url('admin/post/createpost', array('id'=>$this->id)));
    }

    public function getDeleteUrl()
    {
        return l(t('delete', 'admin'), url('admin/post/setdelete', array('id'=>$this->id)), array('class'=>'set-delete'));
    }

    public function getVerifyUrl()
    {
        $text = t(($this->state == AdminPost::STATE_DISABLED) ? 'setshow' : 'sethide', 'admin');
        return l($text, url('admin/post/setVerify', array('id'=>$this->id)), array('class'=>'set-verify'));
    }

    public function getHottestUrl()
    {
        $text = t(($this->hottest == BETA_NO) ? 'set_hottest_post' : 'cancel_hottest_post', 'admin');
        return l($text, url('admin/post/sethottest', array('id'=>$this->id)), array('class'=>'set-hottest'));
    }

    public function getRecommendUrl()
    {
        $text = t(($this->recommend == BETA_NO) ? 'set_recommend_post' : 'cancel_recommend_post', 'admin');
        return l($text, url('admin/post/setrecommend', array('id'=>$this->id)), array('class'=>'set-recommend'));
    }
    
    public function getHomeshowUrl()
    {
        $text = t(($this->homeshow == BETA_YES) ? 'cannel_homeshow_post' : 'set_homeshow_post', 'admin');
        return l($text, url('admin/post/sethomeshow', array('id'=>$this->id)), array('class'=>'set-recommend'));
    }
}