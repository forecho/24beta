<?php
class AppApi
{
    const FORMAT_XML = 'xml';
    const FORMAT_JSON = 'json';
    const FORMAT_JSONP = 'jsonp';
    
    private static $_apiPath;
    private static $_format = 'json';
    private static $_formats = array(
        self::FORMAT_JSON,
        self::FORMAT_JSONP,
        self::FORMAT_XML,
    );
    
    private $_apikey;
    private $_secretKey;
    private $_method;
    private $_sig;
    private $_params;
    
    private $_class;
    private $_function;
    
    /**
     * 构造函数
     */
    public function __construct($apiPath = '')
    {
        $this->init();
    	
        if (empty(self::$_apiPath))
            $this->setApiPath(dirname(__FILE__));
        
        
    }
    
    private function init()
    {
        if (strtolower($_SERVER['REQUEST_METHOD']) === 'get')
            $this->_params = $_GET;
        elseif (strtolower($_SERVER['REQUEST_METHOD']) === 'post')
            $this->_params = $_POST;
        
//        sleep(3);
        set_error_handler(array($this, 'errorHandler'), E_ERROR);
    	set_exception_handler(array($this, 'exceptionHandler'));
    }
    
    /**
     * 设置api类所在的路径
     * @param string $path
     * @throws ApiException
     * @return AppApi
     */
    public function setApiPath($path)
    {
        if (file_exists(realpath($path)))
            self::$_apiPath = rtrim($path, '\/') . DIRECTORY_SEPARATOR;
        else
            throw new ApiException("{$path}目录不存在", ApiError::API_PATH_NO_EXIST);
            
        return $this;
    }
    
    /**
     * 运行AppApi
     */
    public function run()
    {
        $this->checkRequiredParams();
        $this->parseParams($this->_params);
        
        $this->checkParams()->execute();
        exit(0);
    }
    
    /**
     * 检查参数
     * @return AppApi
     */
    private function checkParams()
    {
        $this->checkFormat()
            ->checkApiKey()
           ->checkSignature();
            
        return $this;
    }
    
    /**
     * 执行method对应的命令
     * @throws ApiException
     */
    private function execute()
    {
        $result = call_user_func($this->parsekMethods());
        if (false === $result)
            throw new ApiException('$class->$method 执行错误', ApiError::CLASS_METHOD_EXECUTE_ERROR);
        else {
            $data = array('error'=>0, 'data'=>$result);
            self::output($data, self::$_format);
        }
    }
    
    /**
     * 分析用户提交的参数
     * @param array $params
     * @return AppApi
     */
    private function parseParams($params)
    {
        foreach ($params as $key => $value)
            $params[$key] = strip_tags(trim($value));
            
        $this->_apikey = $params['apikey'];
        $this->_method = $params['method'];
        $this->_sig = $params['sig'];
        
        return $this;
    }
    
    /**
     * 检查必需的参数
     * @throws ApiException
     * @return AppApi
     */
    private function checkRequiredParams()
    {
        $params = array('apikey', 'sig', 'method', 'timestamp');
        $keys = array_keys($this->_params);
        if (array_diff($params, $keys)) {
            throw new ApiException('缺少必须的参数', ApiError::PARAM_NOT_COMPLETE);
        }
        return $this;
    }

    /**
     * 检查apikey
     * @throws ApiException
     * @return AppApi
     */
    private function checkApiKey()
    {
        $keys = (array)require(dirname(__FILE__) . DS . 'keys.php');
        if (array_key_exists($this->_apikey, $keys)) {
            $this->_secretKey = $keys[$this->_apikey];
        }
        else
            throw new ApiException('apikey不存在', ApiError::APIKEY_INVALID);
        return $this;
    }
    
    /**
     * 检查format参数
     * @throws ApiException
     * @return AppApi
     */
    private function checkFormat()
    {
        $format = strtolower(trim(self::$_format));
        if (!in_array($format, self::$_formats)) {
            throw new ApiException('format 参数错误', ApiError::FORMAT_INVALID);
        }
        return $this;
    }
    
    /**
     * 解析method参数
     * @throws ApiException
     * @return array 0=>object, 1=>method
     */
    private function parsekMethods()
    {
        list($class, $method) = explode('.', $this->_method);
        if (empty($class) || empty($method)) {
            throw new ApiException('method参数格式不正确', ApiError::METHOD_FORMAT_ERROR);
        }
        
        $class = 'Api_' . ucfirst($class);
        if (!class_exists($class, false))
            self::importClass($class);

        if (!class_exists($class, false))
            throw new ApiException('$class 类定义不存在', ApiError::CLASS_FILE_NOT_EXIST);
            
        $object = new $class($this->_params);
        if (!method_exists($object, $method))
            throw new ApiException('$method 方法不存在', ApiError::CLASS_METHOD_NOT_EXIST);
        
        return array($object, $method);
    }
    
    /**
     * 导入api类
     * @param string $class
     * @throws ApiException
     */
    private static function importClass($class)
    {
        try {
            require self::$_apiPath . ucfirst($class) . '.php';
        }
        catch (Exception $e) {
            throw new ApiException('$class 文件导入错误', ApiError::CLASS_FILE_NOT_EXIST);
        }
    }
    
    /**
     * 验证用户提交签名是否正确
     * @throws ApiException
     * @return AppApi
     */
    private function checkSignature()
    {
        $sig1 = $this->_sig;
        $sig2 = $this->makeSignature();
        if ($sig1 != $sig2) {
            throw new ApiException('$sig 签名不正确', ApiError::SIGNATURE_ERROR);
        }
        return $this;
    }
    
    /**
     * 计算签名
     * @return string 签名
     */
    private function makeSignature()
    {
        $sig = '123';
        return $sig;
    }
    
    private static function output($data, $format = 'json')
    {
        $method = 'output' . ucfirst(strtolower($format));
        echo self::$method($data);
    }
    
    /**
     * 返回json编码数据
     * @param mixed $data
     * @return string json编码后的数据
     */
    private static function outputJson($data)
    {
        return CJSON::encode($data);
    }
    
    /**
     * 返回xml格式数据
     * @param mixed $data
     * @return string xml数据
     */
    private static function outputXml($data)
    {
        return 'xml';
    }
    
    private static function outputJsonp($data)
    {
        return $this->_params['callback'] . '(' . CJSON::encode($data) . ')';
    }
    
    public static function setDataFormat($format)
    {
        $format = strtolower(trim($format));
        if (in_array($format, self::$_formats)) {
            self::$_format = $format;
            return true;
        }
        else
            throw new ApiException('format 参数错误', ApiError::FORMAT_INVALID);
    }
    
    public function errorHandler($errno, $message, $file, $line)
    {
        $data = array('error' => 1);
        if (isset($this->_params[debug]) && $this->_params[debug])
            $data = array_merge($data, array('errno'=>$errno, 'message'=>$error, 'line'=>$line, 'file'=>$file));
    	echo json_encode($data);
    	exit(0);
    }
    
    public function exceptionHandler($e)
    {
        $data = array('error' => 1);
    	if (isset($this->_params['debug']) && $this->_params['debug'])
    		$data = array_merge($data, array('errno'=>$e->getCode(), 'message'=>$e->getMessage()));
        echo json_encode($data);
    	exit(0);
    }
    
}