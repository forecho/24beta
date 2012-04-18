<?php
class BetaBase
{
    const FILE_NO_EXIST = -1; // '目录不存在并且无法创建';
    const FILE_NO_WRITABLE = -2; // '目录不可写';
    
    
    /**
     * 获取客户端IP地址
     * @return string 客户端IP地址
     */
    public static function getClientIp()
    {
        if ($_SERVER['HTTP_CLIENT_IP']) {
	      $ip = $_SERVER['HTTP_CLIENT_IP'];
	 	} elseif ($_SERVER['HTTP_X_FORWARDED_FOR']) {
	      $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	 	} else {
	      $ip = $_SERVER['REMOTE_ADDR'];
	 	}

        return $ip;
    }
    
    /**
     * 返回上传后的文件路径
     * @return string|Array 如果成功则返回路径地址，如果失败则返回错误号和错误信息
     * -1 目录不存在并且无法创建
     * -2 目录不可写
     */
    public static function makeUploadPath($additional = null)
    {
        $relativeUrl = (($additional === null) ? '' : $additional . '/') . date('Y/m/d/', $_SERVER['REQUEST_TIME']);
        $relativePath = (($additional === null) ? '' : $additional . DS) . date(addslashes(sprintf('Y%sm%sd%s', DS, DS, DS)), $_SERVER['REQUEST_TIME']);

        $path = param('uploadBasePath') . $relativePath;

        if (!file_exists($path) && !mkdir($path, 0755, true)) {
            return self::FILE_NO_EXIST;
        } else if (!is_writable($path)) {
            return self::FILE_NO_WRITABLE;
        } else
            return array(
            	'path' => realpath($path) . DS,
                'url' => $relativeUrl,
            );
    }

    /**
     * 生成文件名
     * @param string $filename 软件名
     * @return string 转化之后的名称
     */
    public static function makeUploadFileName($extension)
    {
        $extension = strtolower($extension);
        $file =  date('YmdHis_', $_SERVER['REQUEST_TIME'])
            . uniqid()
            . ($extension ? '.' . $extension : '');
        
        return $file;
    }
    
    public static function makeUploadFilePath($extension, $additional = null)
    {
        $path = self::makeUploadPath($additional);
        $file = self::makeUploadFileName($extension);
        
        $data = array(
            'path' => $path['path'] . $file,
            'url' => $path['url'] . $file,
        );
        
        return $data;
    }
    
    public static function encryptPassword($password)
    {
        if (empty($password))
            return '';
        else
            return md5($password);
    }

    public static function jsonp($callback, $data, $exit = true)
    {
        if (empty($callback))
            throw new CException('callback is not allowed empty');
        
        echo $callback . '(' . CJSON::encode($data) . ')';
        if ($exit) exit(0);
    }
}