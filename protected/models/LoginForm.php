<?php
class LoginForm extends CFormModel
{
    public $email;
    public $username;
    public $password;
    public $captcha;
    public $rememberMe = 1;
    public $agreement;
    public $returnUrl;

    private $_identity;
    private static $_maxLoginErrorNums = 3;

    public function rules()
    {
        return array(
            array('email', 'required', 'message'=>'请输入您的email'),
            array('email', 'unique', 'className'=>'User', 'attributeName'=>'email', 'on'=>'signup', 'message'=>'该email已经被已经'),
            array('email', 'email'),
            array('username', 'required', 'message'=>'请输入您的大名', 'on'=>'signup'),
            array('username', 'unique', 'className'=>'User', 'attributeName'=>'name', 'on'=>'signup', 'message'=>'该大名已被人抢了，您老请换换'),
            array('username', 'checkReserveWords'),
            array('password', 'required', 'on'=>'signup', 'message'=>'请输入您的密码'),
            array('password', 'authenticate', 'on'=>'login'),
            array('captcha', 'captcha', 'allowEmpty'=>!$this->getEnableCaptcha(), 'on'=>'login'),
            array('captcha', 'captcha', 'allowEmpty'=>false, 'on'=>'signup'),
            array('rememberMe', 'boolean', 'on'=>'login'),
            array('username, password', 'length', 'min'=>3, 'max'=>50),
            array('email, returnUrl', 'length', 'max'=>255),
            array('agreement', 'compare', 'compareValue'=>true, 'on'=>'signup', 'message'=>'请同意挖图么的服务条款和协议'),
            array('rememberMe', 'in', 'range'=>array(0, 1)),
        );
    }
    
    public function checkReserveWords($attribute, $params)
    {
        if ($this->hasErrors('username')) return false;
        foreach ((array)param('reservedWords') as $v) {
            $pos = strpos($this->$attribute, $v);
            if (false !== $pos) {
                $this->addError($attribute, '该大名已被人抢了，请换一个');
                break;
            }
        }
        return true;
    }

    public function authenticate($attribute, $params)
    {
        if ($this->hasErrors('email')) return false;
        $this->_identity = new UserIdentity($this->email, $this->password);

        if (!$this->_identity->authenticate()) {
            $this->addError($attribute, '邮箱或密码错误');
        }
    }

    public function attributeLabels()
    {
        return array(
            'username' => t('username'),
            'password' => t('password'),
            'captcha' => t('captcha'),
            'rememberMe' => t('member_me'),
            'email' => t('email'),
        	'agreement' => t('agreement'),
            'reutrnUrl' => 'Return Url',
        );
    }

    /**
     * 用户登陆
     */
    public function login()
    {
        $duration = (user()->allowAutoLogin && $this->rememberMe) ? param('autoLoginDuration') : 0;
        if (user()->login($this->_identity, $duration)) {
            $this->afterLogin();
            return true;
        }
        else
            return false;
    }

    /**
     * 创建新账号
     */
    public function signup()
    {
        $user = new User();
	    $user->email = $this->email;
	    $user->name = $this->username;
	    $user->password = md5($this->password);
	    $result = $user->save();

	    if ($result) {
	        $this->afterSignup($user);
	        return true;
	    }
	    else
	        return false;
    }

    public function incrementErrorLoginNums()
    {
        $errorNums = (int)$_COOKIE['loginErrorNums'];
        setcookie('loginErrorNums', ++$errorNums, $_SERVER['REQUEST_TIME'] + 3600, param('cookiePath'), param('cookieDomain'));
    }

    public function clearErrorLoginNums()
    {
        return setcookie('loginErrorNums', null, null, param('cookiePath'), param('cookieDomain'));
    }

    public function getEnableCaptcha()
    {
        $errorNums = (int)$_COOKIE['loginErrorNums'];
        return $errorNums >= self::$_maxLoginErrorNums;
    }

    public function afterValidate()
    {
        parent::afterValidate();
        if ($this->hasErrors())
            $this->incrementErrorLoginNums();
        else
            $this->clearErrorLoginNums();
    }

    public function afterLogin()
    {
        $returnUrl = urldecode($this->returnUrl);
        if (empty($returnUrl))
            $returnUrl = strip_tags(trim($_GET['url']));
        if (empty($returnUrl))
                $returnUrl = aurl('user/default');
        
        request()->redirect($returnUrl);
        exit(0);
    }
    
    public function afterSignup($user)
    {
        user()->loginRequired();
        exit(0);
    }
}


