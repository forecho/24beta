<?php
class AdminUpload extends Upload
{
    /**
     * Returns the static model of the specified AR class.
     * @return AdminUpload the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
    
    public static function fetchList($criteria = null, $sort = true, $pages = true)
    {
        $criteria = ($criteria === null) ? new CDbCriteria() : $criteria;
        if ($criteria->limit <= 0)
            $criteria->limit = param('adminUploadFilesCountOfPage');
    
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
    
    public function getEditLink()
    {
        return l(t('edit', 'admin'), url('admin/upload/edit', array('id'=>$this->id)));
    }
    
    public function getDeleteLink()
    {
        return l(t('delete', 'admin'), url('admin/upload/delete', array('id'=>$this->id)));
    }
    
    
    public function getPreviewLink()
    {
        if ($this->file_type == UPLOAD_TYPE_PICTURE)
            $html = l(t('view_picture', 'admin'), $this->getFileUrl(), array('target'=>'_blank', 'class'=>'preview-picture'));
        else
            $html = '';
        
        return $html;
    }
}