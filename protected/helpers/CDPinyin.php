<?php
class CDPinyin
{
    private static $_dict = null;
    
    public static function getDict()
    {
        $dict = (null !== self::$_dict && is_array(self::$_dict))
            ? self::$_dict
            : require(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'pinyins.php');
        return $dict;
    }
    
    /**
     * 将汉字转换成拼音，只保留汉字及数字，其它字符过滤掉，拼音之间用-连接
     * @param string $str 待转换字符串
     * @return string 拼音字符串
     */
    public static function pinyin($str, $separate = '-')
    {
        if (empty($str)) return false;
        
        $dict = self::getDict();
	    $len = mb_strlen($str);
	    for ($i=0; $i<$len; $i++) {
	        $word = mb_substr($str, $i, 1, app()->charset);
	        if (array_key_exists($word, $dict)) {
	            if (!empty($tmp)) {
	                $pinyin[] = $tmp;
	                unset($tmp);
	            }
	            $pinyin[] = $dict[$word];
	        }
	        else
	            if (preg_match('/^[\w\d]+$/i', $word)) $tmp .= $word;
	    }
	    
        if (!empty($tmp)) {
            $pinyin[] = $tmp;
            unset($tmp);
        }
	    return join($pinyin, $separate);
    }
    
    /**
     * 返回一个汉字的拼音
     * @param char $word 一个汉字
     * @return string 汉字的拼音
     */
    public static function oneWord($word)
    {
        $dict = self::getDict();
        if (array_key_exists($word, $dict))
            return $dict[$word];
        else
            return null;
    }
    
    /**
     * 将汉字首字母转换成拼音
     * @param $str 待处理字符串
     * @return char 字符串拼音首字母
     */
    public static function firstLetter($str)
    {
        if (empty($str)) return false;
    	$word = mb_substr($str, 0, 1, app()->charset);
    	if (strlen($word) == 1) {
    		return strtoupper($word);
    	} else {
    		$dict = self::getDict();
    		return $dict[$word] ? strtoupper(substr($dict[$word], 0, 1)) : '';
    	}
    }
}