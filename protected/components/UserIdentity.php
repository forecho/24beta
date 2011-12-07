<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
    private $_id;

	public function authenticate()
	{
	    if ($this->isAuthenticated) return true;
	    
		$name = strtolower($this->username);
	    $user = User::model()->find('LOWER(`username`) = ?', array($name));

		if ($user === null)
			$this->errorCode = self::ERROR_USERNAME_INVALID;
		elseif ($user->password != md5($this->password))
			$this->errorCode = self::ERROR_PASSWORD_INVALID;
		else {
			$this->errorCode = self::ERROR_NONE;
			$this->_id = $user->id;
			
			$this->cacheUserData($user);
		}
		return !$this->errorCode;
	}
	
	public function getId()
	{
	    return $this->_id;
	}

	/**
	 * 设置用户资料，放入session中
	 * @param User $user
	 */
	private function cacheUserData($u)
	{
	    
	}
}