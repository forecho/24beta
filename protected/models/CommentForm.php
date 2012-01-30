<?php
class CommentForm extends CFormModel
{
    public $id;
    public $post_id;
    public $content;
    public $user_name;
    public $user_email;
    public $user_site;
    public $captcha;
    
    public function rules()
    {
        return array(
            array('post_id, content', 'required'),
            array('id, post_id', 'numerical', 'integerOnly'=>true),
			array('user_name', 'length', 'max'=>50),
	        array('user_email, user_site', 'length', 'max'=>250),
	        array('user_email', 'email'),
	        array('user_site', 'url'),
            array('captcha', 'captcha', 'allowEmpty'=>$this->captchaAllowEmpty()),
			array('content', 'safe'),
        );
    }
    
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'post_id' => t('post_id'),
            'content' => t('content'),
            'user_name' => t('user_name'),
            'user_email' => t('user_email'),
            'user_site' => t('user_site'),
            'captcha' => t('captcha'),
        );
    }
    
    public function save()
    {
        $comment = new Comment();
        $comment->attributes = $this->attributes;
        $comment->user_id = (int)user()->id;
        $comment->state = (int)param('defaultNewCommentState');
        $result = $comment->save();
        $this->afterSave();
        return $result;
    }
        
    public function afterSave()
    {
        
    }
    
    public function captchaAllowEmpty()
    {
        return false;
    }
        
}