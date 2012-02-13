<?php
class CommentForm extends CFormModel
{
    public $post_id;
    public $content;
    public $captcha;
    
    public function rules()
    {
        return array(
            array('post_id, content', 'required'),
            array('post_id', 'numerical', 'integerOnly'=>true),
            array('captcha', 'captcha', 'allowEmpty'=>$this->captchaAllowEmpty()),
			array('content', 'safe'),
        );
    }
    
    public function attributeLabels()
    {
        return array(
            'post_id' => t('post_id'),
            'content' => t('content'),
            'captcha' => t('captcha'),
        );
    }
    
    public function save()
    {
        $comment = new Comment();
        $comment->attributes = $this->attributes;
        $comment->user_id = (int)user()->id;
        $comment->state = (int)param('defaultNewCommentState');
        $comment->save();
        $this->afterSave();
        return $comment;
    }
        
    public function afterSave()
    {
        
    }
    
    public function captchaAllowEmpty()
    {
        return false;
    }
        
}