<?php
/**
 * AdminTopic
 * @author chendong
 * @property string $postListLink
 */
class AdminTopic extends Topic
{
    /**
     * Returns the static model of the specified AR class.
     * @return AdminTopic the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function getPostListLink()
    {
        return l($this->name, url('admin/post/latest', array('tid'=>$this->id)));
    }
    
    public function saveIcon()
    {
        if ($this->icon && $this->icon instanceof CUploadedFile) {
            $topicThumbnailDir = 'topic';
            $filename = BetaBase::uploadImage($this->icon, 'topic');
            if ($filename === false)
                return false;
            else {
                $this->icon = $filename['url'];
                $this->update(array('icon'));
                return $filename;
            }
        }
        else
            return null;
    }
}