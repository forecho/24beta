<?php
/**
 * @author chendong
 *
 * @property string $infoUrl
 * @property string $editurl
 * @property string $verifyUrl
 * @property string $stateText;
 */
class AdminUser extends User
{
    /**
     * Returns the static model of the specified AR class.
     * @return AdminUser the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function getInfoUrl()
    {
        return url('admin/user/info', array('id'=>$this->id));
    }
    
    public function getEditUrl()
    {
        return l(t('edit', 'admin'), url('admin/user/create', array('id'=>$this->id)));
    }
    
    public function getVerifyUrl()
    {
        $text = t(($this->state == AdminUser::STATE_DISABLED) ? 'user_enabled' : 'user_disabled', 'admin');
        return l($text, url('admin/user/setVerify', array('id'=>$this->id)), array('class'=>'set-verify'));
    }
    
    public function getResetPasswordUrl()
    {
        return l(t('reset_password', 'admin'), url('admin/user/resetPassword', array('id'=>$this->id)));
    }
    
    public function getStateText()
    {
        if ($this->state == self::STATE_ENABLED)
	        $html = '<span class="label label-success">' . t('user_enabled', 'admin') . '</span>';
	    else
	        $html = $html = '<span class="label label-important">' . t('user_disabled', 'admin') . '</span>';
	    
	    return $html;
    }
    
    public static function fetchList($criteria = null, $sort = true, $pages = true)
    {
        $criteria = ($criteria === null) ? new CDbCriteria() : $criteria;
        if ($criteria->limit <= 0)
            $criteria->limit = param('adminUserCountOfPage');
         
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
         
        $models = self::model()->findAll($criteria);
         
        $data = array(
            'models' => $models,
            'sort' => $sort,
            'pages' => $pages,
        );
         
        return $data;
    }
    
}