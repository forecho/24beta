<?php
class AdminSpecial extends Special
{
    /**
     * Returns the static model of the specified AR class.
     * @return AdminSpecial the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
    
    public function getStateBadgeHtml()
    {
        $class = $this->state ? 'badge-success' : 'badget-error';
        $html = sprintf('<span class="badge %s">%s</span>', $class, $this->state);
        return $html;
    }
    

    public function getEditUrl()
    {
        return url('admin/special/create', array('id'=>$this->id));
    }
    
    public function getEditLink()
    {
        return l(t('edit', 'admin'), $this->getEditUrl());
    }
    
    public function getStateLink()
    {
        $text = t($this->state ? 'special_disabled' : 'special_enabled', 'admin');
        return l($text, url('admin/special/setstate', array('id'=>$this->id)), array('class'=>'set-state'));
    }
    
    public function getDeleteLink()
    {
        return l(t('delete', 'admin'), url('admin/special/setdelete', array('id'=>$this->id)), array('class'=>'set-delete'));
    }
    
    public static function fetchList(CDbCriteria $criteria = null, $pages = true, $sort = false)
    {
        if ($criteria === null)
            $criteria = new CDbCriteria();
        
        if ($pages) {
            $limit = ($criteria->limit) <= 0 ? param('adminSpecialCountOfPage') : $criteria->limit;
            $pages = new CPagination(self::model()->count($criteria));
            $pages->setPageSize($limit);
            $pages->applyLimit($criteria);
            $data['pages'] = $pages;
        }
        
        if ($sort) {
            $sort = new CSort('AdminSpecial');
            $sort->defaultOrder = 'create_time desc';
            $sort->applyOrder($criteria);
            $data['sort'] = $sort;
        }
        else
            $criteria->order = 'create_time desc';
        
        $data['models'] = self::model()->findAll($criteria);
        
        if (empty($data['models']))
            $data = array();
        
        return $data;
    }
    
    public function saveThumbnail()
    {
        if ($this->thumbnail && $this->thumbnail instanceof CUploadedFile) {
            $topicThumbnailDir = 'special';
            $filename = BetaBase::uploadImage($this->thumbnail, 'special');
            if ($filename === false)
                return false;
            else {
                $this->thumbnail = $filename['url'];
                $this->update(array('thumbnail'));
                return $filename;
            }
        }
        else
            return null;
    }
}