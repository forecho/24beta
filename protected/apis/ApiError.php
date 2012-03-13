<?php
class ApiError
{
	/**
	 * 系统错误
	 * @var integer
	 */
	const SYSTEM_ERROR = 1;
	
    /**
     * api 路径不存在
     * @var integer
     */
    const API_PATH_NO_EXIST = 10;
    
    /**
     * http 请求方式错误
     * @var integer
     */
    const HTTP_METHOD_ERROR = 20;
    
    /**
     * class 文件不存在
     * @var integer
     */
    const CLASS_FILE_NOT_EXIST = 100;
    
    /**
     * class->method 不存在
     * @var integer
     */
    const CLASS_METHOD_NOT_EXIST = 101;
    
    /**
     * class->method 执行错误
     * @var integer
     */
    const CLASS_METHOD_EXECUTE_ERROR = 102;

    /**
     * 用户提交参数不完整
     * @var integer
     */
    const PARAM_NOT_COMPLETE = 200;

    /**
     * apikey 不合法
     * @var integer
     */
    const APIKEY_INVALID = 300;

    /*
     * format 不合法
     */
    const FORMAT_INVALID = 400;
    
    /**
     * method 参数格式错误
     * @var integer
     */
    const METHOD_FORMAT_ERROR = 500;

    /**
     * 签名错误
     * @var integer
     */
    const SIGNATURE_ERROR = 600;
    
    /**
     * 用户不存在
     * @var integer
     */
    const USER_NOT_EXIST = 1000;
    
    /**
     * 用户$token错误
     * @var integer
     */
    const USER_TOKEN_ERROR = 10001;
    
    
}