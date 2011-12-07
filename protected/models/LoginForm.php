<?php
class LoginForm extends CFormModel
{
    public $email;
    public $username;
    public $password;
    public $validateCode;
    public $rememberMe = 1;
    public $agreement;

    private $_identity;
    private static $_maxLoginErrorNums = 3;

    public function rules()
    {
        return array(
            array('email', 'required', 'message'=>'请输入您的email'),
            array('email', 'unique', 'className'=>'User', 'attributeName'=>'email', 'on'=>'insert', 'message'=>'该email已经被已经'),
            array('email', 'email'),
            array('username', 'required', 'message'=>'请输入您的大名', 'on'=>'insert, update'),
            array('username', 'unique', 'className'=>'User', 'attributeName'=>'username', 'on'=>'insert', 'message'=>'该大名已被人抢了，您老请换换'),
            array('username', 'checkReserveWords'),
            array('password', 'required', 'on'=>'insert', 'message'=>'请输入您的密码'),
            array('password', 'authenticate', 'on'=>'login'),
            array('validateCode', 'captcha', 'allowEmpty'=>!self::getEnableCaptcha(), 'on'=>'login'),
            array('validateCode', 'captcha', 'allowEmpty'=>false, 'on'=>'insert'),
            array('rememberMe', 'boolean', 'on'=>'login'),
            array('username, password', 'length', 'min'=>3, 'max'=>50),
            array('email', 'length', 'max'=>255),
            array('agreement', 'compare', 'compareValue'=>true, 'on'=>'insert', 'message'=>'请同意挖图么的服务条款和协议'),
            array('rememberMe', 'in', 'range'=>array(0, 1)),
        );
    }
    
    public function checkReserveWords($attribute, $params)
    {
        if ($this->hasErrors('username')) return false;
        foreach ((array)param('reservedWords') as $v) {
            $pos = strpos($this->$attribute, $v);
            if (false !== $pos) {
                $this->addError($attribute, '该大名已被人抢了，您老请换换');
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
            'username' => '大名',
            'password' => '密码',
            'validateCode' => '验证码',
            'rememberMe' => '记住我',
            'email' => '邮箱',
        	'agreement' => '服务条款和协议',
        );
    }

    /**
     * 用户登陆
     */
    public function login()
    {
        if (empty($this->_identity))
            $this->_identity = new UserIdentity($this->email, $this->password);
        if ($this->_identity->authenticate()) {
            $duration = (user()->allowAutoLogin && $this->rememberMe) ? param('autoLoginDuration') : 0;
            user()->login($this->_identity, $duration);
        }
    }

    /**
     * 创建新账号
     */
    public function createUser()
    {
        $user = new User();
	    $user->email = $this->email;
	    $user->username = $this->username;
	    $user->password = $this->password;
	    $result = $user->save();

	    if (!$result) return false;
        return $user;
    }

    public static function incrementErrorLoginNums()
    {
        $errorNums = (int)$_COOKIE['loginErrorNums'];
        setcookie('loginErrorNums', ++$errorNums, $_SERVER['REQUEST_TIME'] + 3600, param('cookiePath'), param('cookieDomain'));
    }

    public static function clearErrorLoginNums()
    {
        return setcookie('loginErrorNums', null, null, param('cookiePath'), param('cookieDomain'));
    }

    public static function getEnableCaptcha()
    {
        $errorNums = (int)$_COOKIE['loginErrorNums'];
        return ($errorNums >= self::$_maxLoginErrorNums) ? true : false;
    }

    public function afterValidate()
    {
        parent::afterValidate();
        if ($this->getErrors())
            self::incrementErrorLoginNums();
        else
            self::clearErrorLoginNums();
    }

}