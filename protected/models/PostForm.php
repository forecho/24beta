<?php
class PostForm extends CFormModel
{
    public $category_id = 0;
    public $topic_id = 0;
    public $title;
    public $summary;
    public $content;
    public $source;
    public $contributor_id;
    public $contributor;
    public $contributor_email;
    public $contributor_site;
    public $tags;
    public $captcha;
    public $token;
    
    public function rules()
    {
        return array(
            array('title, summary, content', 'required'),
            array('category_id, topic_id', 'numerical', 'integerOnly'=>true),
			array('contributor', 'length', 'max'=>50),
	        array('contributor_email, contributor_site, source, tags', 'length', 'max'=>250),
	        array('contributor_email', 'email'),
	        array('contributor_site', 'url'),
            array('captcha', 'captcha', 'allowEmpty'=>$this->captchaAllowEmpty()),
			array('summary, content', 'safe'),
        );
    }
    
    public function attributeLabels()
    {
        return array(
			'category_id' => t('category'),
			'topic_id' => t('topic'),
			'title' => t('title'),
			'summary' => t('summary'),
			'content' => t('content'),
		    'contributor_id' => t('contributor_id'),
		    'contributor' => t('contributor'),
		    'contributor_site' => t('contributor_site'),
		    'contributor_email' => t('contributor_email'),
	        'source' => t('source'),
			'tags' => t('tags'),
            'captcha' => t('captcha'),
        );
    }
    
    public function save()
    {
        $post = new Post();
        $post->attributes = $this->attributes;
        $post->post_type = Post::TYPE_POST;
        $post->contributor_id = (int)user()->id;
        if (empty($post->contributor))
            $post->contributor = user()->name;
        $post->state = $this->state();
        $post->user_id = user()->id;
        $post->user_name = user()->name;
        $post->homeshow = $this->homeshow();
        $post->save();
        $this->afterSave($post);
        return $post;
    }
    
    public function state()
    {
        return user()->checkAccess('chief_editor') ? Post::STATE_ENABLED : Post::STATE_DISABLED;
    }
    
    public function homeshow()
    {
        return user()->checkAccess('create_post_in_home') ? BETA_YES : param('defaultPostShowHomePage');
    }
        
    public function afterSave(Post $post)
    {
        $key = param('sess_post_create_token');
        if (app()->session->contains($key) && $token = app()->session[$key]) {
            if (!$post->hasErrors()) {
                $attributes = array('post_id'=>$post->id, 'token'=>'');
                Upload::model()->updateAll($attributes, 'token = :token', array(':token'=>$token));
                app()->session->remove($key);
            }
        }
    }
    
    public function captchaAllowEmpty()
    {
        return user()->checkAccess('editor');
    }

    
}