<?php
/**
 * Api 基础类
 * @author Chris
 * @copyright cdcchen@gmail.com
 * @package api
 */
class ApiBase
{
    protected $_params;
    
    public function __construct($params)
    {
        unset($params['method'], $params['sig'], $params['apikey'], $params['format']);
        $this->_params = $params;
        $this->init();
    }
    
    public function init()
    {
    }
    
    protected static function requirePost()
    {
        self::requireMethods('POST');
    }
    
    protected static function requireGet()
    {
        self::requireMethods('GET');
    }
    
    protected static function requireMethods($methods)
    {
        $methods = array($methods);

        $methods = array_map('strtoupper', $methods);
        if (!isset($_SERVER['REQUEST_METHOD']) || !in_array($_SERVER['REQUEST_METHOD'], $methods, true)) {
            $methodString = join('|', $methods);
            throw new ApiException("此方法必须使用{$methodString}请求", ApiError::HTTP_METHOD_ERROR);
        }
    }
    
    protected function requiredParams($params)
    {
        $params = (array)$params;
        
        $allParams = array_keys($this->_params);
        $diff = join('|', array_diff($params, $allParams));
        if ($diff) {
            throw new ApiException("请求参数不完整，缺少参数：{$diff}", ApiError::PARAM_NOT_COMPLETE);
        }
    }
    
    protected function filterParams($params = array())
    {
        $params = (array)$params;
        
        $params[] = 'debug';
        foreach ($params as $key) {
            if (array_key_exists($key, $this->_params))
                $data[$key] = $this->_params[$key];
        }

        return (array)$data;
    }
    
    protected function requireLogin()
    {
    	if (!isset($this->_params['token']) || empty($this->_params['token']))
    		throw new ApiException('此api需要用户登录', ApiError::USER_TOKEN_ERROR);
    }
}
?>