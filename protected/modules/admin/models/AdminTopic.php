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
            $path = BetaBase::makeUploadPath(param('uploadBasePath'), $topicThumbnailDir);
            $file = BetaBase::makeUploadFileName(null);
            $filename = $path['path'] . $file;
            try {
                $im = new CdImage();
                $im->load($this->icon->tempName);
                $im->saveAsJpeg($filename);
                $this->icon = $path['url'] . $im->filename();
                return $this->update(array('icon'));
            }
            catch (Exception $e) {
                echo $e->getMessage();
                return false;
            }
        }
        else
            return null;
    }
}