<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
    private $_id;
    private $_name;

	public function authenticate()
	{
	    $email = strtolower($this->username);
	    $user = User::model()->find('email = ?', array($email));

		if ($user === null)
			$this->errorCode = self::ERROR_USERNAME_INVALID;
		elseif ($user->password != md5($this->password))
			$this->errorCode = self::ERROR_PASSWORD_INVALID;
		else {
			$this->errorCode = self::ERROR_NONE;
			$this->_id = $user->id;
			$this->_name = $user->name;
			$this->cacheUserData($user);
		}
		return !$this->errorCode;
	}
	
	public function getId()
	{
	    return $this->_id;
	}
	
	public function getEmail()
	{
	    return $this->username;
	}
	
	public function getName()
	{
	    return $this->_name;
	}

	/**
	 * 设置用户资料，放入session中
	 * @param User $user
	 */
	private function cacheUserData($u)
	{
	    $s = app()->session;
	}
}