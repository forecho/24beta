<?php
class CdTopApi extends CdCurl
{
    private static $_api_url = 'http://gw.api.taobao.com/router/rest';
    private static $_sandbox_url = 'http://gw.api.tbsandbox.com/router/rest';
    private $_api_version = '2.0';
    private $_api_key;
    private $_api_secret;
    private $_sandbox_secret;
    private $_format = 'json';
    private $_sign;
    private $_sing_method = 'md5';
    
    private $_args;
    private $_data;
    private static $_debug = false;
    
    public function __construct($api_key, $api_secret, $sandbox_secret)
    {
        if (empty($api_key))
            throw new Exception('$api_key参数是必需的.');
            
        if (self::$_debug && empty($sandbox_secret))
            throw new Exception('在沙箱环境中$sandbox_secret是必需的.');

        if (!self::$_debug && empty($api_secret))
            throw new Exception('在正式环境中$api_secret是必需的.');

        $this->_api_key = $api_key;
        $this->_api_secret = $api_secret;
        $this->_sandbox_secret = $sandbox_secret;
        
        parent::__construct();
        
        $this->init();
    }
    
    public function init()
    {
        $this->apikey()
            ->timestamp()
            ->version()
            ->format()
            ->sign_method();
        return $this;
    }
    
    private function apikey()
    {
        $this->add_args('api_key', $this->_api_key);
        return $this;
    }
    
    public function signature()
    {
        if (!is_array($this->_args)) return null;
    
        ksort($this->_args);
        reset($this->_args);
        $sign = $secret = $this->get_secret();
        foreach ($this->_args as $k => $v) $sign .= $k . $v;
        $sign .= $secret;
        
        $method = $this->_args['sign_method'];
        $this->_sign = strtoupper($method($sign));
        $this->add_args('sign', $this->_sign);
        return $this;
    }
    
    private function get_secret()
    {
        return self::$_debug ? $this->_sandbox_secret : $this->_api_secret;
    }
    
    public function timestamp($ts = null)
    {
        if (null === $id)
            $ts = date('Y-m-d H:i:s');
        $this->add_args('timestamp', $ts);
        return $this;
    }
    
    /**
     * 暂时无用
     * @param string $key
     */
    public function session_key($key = null)
    {
        if (null === $key)
            $key = $_GET['xn_sig_session_key'];
        $this->add_args('session_key', $key);
        return $this;
    }
    
    public function add_args($name, $value)
    {
        if (empty($name)) return $this;
        
        if (is_string($name))
            $this->_args[$name] = $value;
        elseif (is_array($name)) {
            foreach ($name as $k => $v)
                $this->_args[$k] = $v;
        }
        return $this;
    }
    
    public function version($version = null)
    {
        if (null !== $version)
            $this->_api_version = $version;
            
        $this->add_args('v', $this->_api_version);
        return $this;
    }
    
    public function format($format = null)
    {
        if (null === $format) {
            $this->add_args('format', $this->_format);
            return $this;
        }
        
        $formats = array('xml', 'json');
        if (!in_array($format, $formats))
            throw new Exception('不支持的数据格式：' . $format);

        $this->_format = $format;
        $this->add_args('format', $this->_format);
        return $this;
        
    }
    
    public function method($method)
    {
        if (null !== $method)
            $this->add_args('method', $method);
        return $this;
    }
    
    public function sign_method($method = null)
    {
        if (null === $method) {
            $this->add_args('sign_method', $this->_sing_method);
            return $this;
        }
        
        $methods = array('md5', 'hmac');
        if (!in_array($method, $methods))
            throw new Exception('不支持的签名方法：' . $method);

        $this->_sing_method = $method;
        $this->add_args('sign_method', $this->_sing_method);
        return $this;
    }
    
    public function api_url()
    {
        return self::$_debug ? self::$_sandbox_url : self::$_api_url;
    }
    
    
    public function request()
    {
        if (!array_key_exists('api_key', $this->_args) || !array_key_exists('method', $this->_args))
            throw new Exception('api_key and method is required');
            
        $this->signature();
        $url = $this->api_url();
        $this->_data = $this->get($url, $this->_args)->rawdata();
        return $this;
    }
    
    public function data()
    {
        $method = strtolower($this->_format);
        if (method_exists($this, $method))
            return $this->$method();
        else
            throw new Exception('指定的format不支持');
    }
    
    public function xml()
    {
        return $this->_data;
    }
    
    public function json()
    {
        return json_decode($this->_data, true);
    }
    
    public function crevert()
    {
        parent::revert();
        
        $this->_args = array();
        $this->init();
        return $this;
    }
    
    public static function debug($debug = true)
    {
        self::$_debug = (bool)$debug;
    }
    
}