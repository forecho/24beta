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
    public static function makeUploadPath($basePath, $additional = null)
    {
        $relativeUrl = (($additional === null) ? '' : $additional . '/') . date('Y/m/d/', $_SERVER['REQUEST_TIME']);
        $relativePath = (($additional === null) ? '' : $additional . DS) . date(addslashes(sprintf('Y%sm%sd%s', DS, DS, DS)), $_SERVER['REQUEST_TIME']);

        $path = $basePath . $relativePath;

        if ((file_exists($path) || mkdir($path, 0755, true)) && is_writable($path))
            return array(
            	'path' => realpath($path) . DS,
                'url' => $relativeUrl,
            );
        else
            throw new Exception('path not exist or not writable', 0);
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
    
    public static function makeUploadFilePath($basePath, $extension, $additional = null)
    {
        $path = self::makeUploadPath($basePath, $additional);
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

    public static function uploadImage(CUploadedFile $upload, $additional = null, $compress = true, $deleteTempFile = true)
    {
        if (!$compress) {
            $result = self::uploadFile($upload, $additional, $deleteTempFile);
            return $result;
        }
        
        $path = self::makeUploadPath(param('uploadBasePath'), $additional);
        $file = self::makeUploadFileName(null);
        $filename = $path['path'] . $file;
        $im = new CdImage();
        $im->load($upload->tempName);
        $result = $im->save($filename);
        $newFilename = $im->filename();
        unset($im);
        if ($result === false)
            return false;
        else {
            $filename = array(
                'path' => $path['path'] . $newFilename,
                'url' => $path['url'] . $newFilename
            );
            return $filename;
        }
    }
    
    public static function uploadFile(CUploadedFile $upload, $additional = null, $deleteTempFile = true)
    {
        $filename = self::makeUploadFilePath(param('uploadBasePath'), $upload->extensionName);
        $result = $upload->saveAs($filename['path'], $deleteTempFile);
        if ($result)
            return $filename;
        else
            return false;
    }

    public static function filterText($text)
    {
        static $keywords = null;
        if ($keywords === null) {
            $filename = dp('filter_keywords.php');
            if (file_exists($filename) && is_readable($filename)) {
                $keywords = require($filename);
            }
            else
                return $text;
        }
//         var_dump($keywords);exit;
        if (empty($keywords)) return $text;

        try {
            $patterns = array_keys($keywords);
            foreach ($patterns as $index => $pattern) {
                $patterns[$index] = '/' . $pattern . '/is';
            }
            
            $replacement = array_values($keywords);
            foreach ($replacement as $index => $word)
                $replacement[$index] = empty($word) ? param('filterKeywordReplacement') : $word;
            
            $result = preg_replace($patterns, $replacement, $text);
            $newText = ($result === null) ? $text : $result;
        }
        catch (Exception $e) {
            $newText = $text;
        }
        
        return $newText;
    }
}