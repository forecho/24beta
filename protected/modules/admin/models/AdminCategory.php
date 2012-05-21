<?php
/**
 * AdminCategory
 * @author chendong
 * @property string $postListLink
 */
class AdminCategory extends Category
{
    /**
     * Returns the static model of the specified AR class.
     * @return AdminCategory the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function getPostListLink()
    {
        return l($this->name, url('admin/post/latest', array('cid'=>$this->id)));
    }

    public function getStateHtml()
    {
        $class = 'label';
        $text = t('category_hide', 'admin');
        if ($this->state == CATEGORY_STATE_IN_NAV) {
            $class .= ' label-success';
            $text = t('category_show', 'admin');
        }
        
        $html = '<span class="' . $class . '">' . $text . '</span>';
        return $html;
    }
}