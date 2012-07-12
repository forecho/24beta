<?php
$requirements=array(
    array(
            'PHP版本',
            true,
            version_compare(PHP_VERSION,"5.1.0",">="),
            '<a href="http://www.yiiframework.com">Yii Framework</a>',
            'PHP 5.2.0或更高版本是必须的。'),
    array(
            '$_SERVER变量',
            true,
            ($message=checkServerVar()) === '',
            '<a href="http://www.yiiframework.com">Yii Framework</a>',
            $message),
    array(
            'Reflection扩展模块',
            true,
            class_exists('Reflection',false),
            '<a href="http://www.yiiframework.com">Yii Framework</a>',
            ''),
    array(
            'PCRE扩展模块',
            true,
            extension_loaded("pcre"),
            '<a href="http://www.yiiframework.com">Yii Framework</a>',
            ''),
    array(
            'SPL扩展模块',
            true,
            extension_loaded("SPL"),
            '<a href="http://www.yiiframework.com">Yii Framework</a>',
            ''),
    array(
            'DOM扩展模块',
            false,
            class_exists("DOMDocument",false),
            '<a href="http://www.yiiframework.com/doc/api/CHtmlPurifier">CHtmlPurifier</a>, <a href="http://www.yiiframework.com/doc/api/CWsdlGenerator">CWsdlGenerator</a>',
            ''),
    array(
            'PDO扩展模块',
            false,
            extension_loaded('pdo'),
            t('yii','All <a href="http://www.yiiframework.com/doc/api/#system.db">DB-related classes</a>'),
            ''),
    /*array(
           'PDO SQLite扩展模块',
            false,
            extension_loaded('pdo_sqlite'),
            t('yii','All <a href="http://www.yiiframework.com/doc/api/#system.db">DB-related classes</a>'),
            '如果使用SQLite数据库，这是必须的。'),*/
    array(
            'PDO MySQL扩展模块',
            false,
            extension_loaded('pdo_mysql'),
            t('yii','All <a href="http://www.yiiframework.com/doc/api/#system.db">DB-related classes</a>'),
            '如果使用MySQL数据库，这是必须的。'),
    /*array(
            'PDO PostgreSQL扩展模块',
            false,
            extension_loaded('pdo_pgsql'),
            t('yii','All <a href="http://www.yiiframework.com/doc/api/#system.db">DB-related classes</a>'),
            '如果使用PostgreSQL数据库，这是必须的。'),
    array(
            'Memcache扩展模块',
            false,
            extension_loaded("memcache") || extension_loaded("memcached"),
            '<a href="http://www.yiiframework.com/doc/api/CMemCache">CMemCache</a>',
            extension_loaded("memcached") ? t('yii', 'To use memcached set <a href="http://www.yiiframework.com/doc/api/CMemCache#useMemcached-detail">CMemCache::useMemcached</a> to <code>true</code>.') : ''),
    */
    /*array(
            'APC扩展模块',
            false,
            extension_loaded("apc"),
            '<a href="http://www.yiiframework.com/doc/api/CApcCache">CApcCache</a>',
            ''),*/
    array(
            'Mcrypt扩展模块',
            false,
            extension_loaded("mcrypt"),
            '<a href="http://www.yiiframework.com/doc/api/CSecurityManager">CSecurityManager</a>',
            t('yii','This is required by encrypt and decrypt methods.')),
    /*array(
            'SOAP扩展模块',
            false,
            extension_loaded("soap"),
            '<a href="http://www.yiiframework.com/doc/api/CWebService">CWebService</a>, <a href="http://www.yiiframework.com/doc/api/CWebServiceAction">CWebServiceAction</a>',
            ''),*/
    array(
            'GD extension with<br />FreeType support',
            false,
            ($message=checkGD()) === '',
            //extension_loaded('gd'),
            '<a href="http://www.yiiframework.com/doc/api/CCaptchaAction">CCaptchaAction</a>',
            $message),
    array(
            'Ctype extension',
            false,
            extension_loaded("ctype"),
            '<a href="http://www.yiiframework.com/doc/api/CDateFormatter">CDateFormatter</a>, <a href="http://www.yiiframework.com/doc/api/CDateFormatter">CDateTimeParser</a>, <a href="http://www.yiiframework.com/doc/api/CTextHighlighter">CTextHighlighter</a>, <a href="http://www.yiiframework.com/doc/api/CHtmlPurifier">CHtmlPurifier</a>',
            ''
    )
);

function checkServerVar()
{
    $vars=array('HTTP_HOST','SERVER_NAME','SERVER_PORT','SCRIPT_NAME','SCRIPT_FILENAME','PHP_SELF','HTTP_ACCEPT','HTTP_USER_AGENT');
    $missing=array();
    foreach($vars as $var)
    {
        if(!isset($_SERVER[$var]))
            $missing[]=$var;
    }
    if(!empty($missing))
        return t('yii','$_SERVER does not have {vars}.',array('{vars}'=>implode(', ',$missing)));

    if(realpath($_SERVER["SCRIPT_FILENAME"]) !== realpath(__FILE__))
        return t('yii','$_SERVER["SCRIPT_FILENAME"] must be the same as the entry script file path.');

    if(!isset($_SERVER["REQUEST_URI"]) && isset($_SERVER["QUERY_STRING"]))
        return t('yii','Either $_SERVER["REQUEST_URI"] or $_SERVER["QUERY_STRING"] must exist.');

    if(!isset($_SERVER["PATH_INFO"]) && strpos($_SERVER["PHP_SELF"],$_SERVER["SCRIPT_NAME"]) !== 0)
        return t('yii','Unable to determine URL path info. Please make sure $_SERVER["PATH_INFO"] (or $_SERVER["PHP_SELF"] and $_SERVER["SCRIPT_NAME"]) contains proper value.');

    return '';
}

function checkGD()
{
    if(extension_loaded('gd'))
    {
        $gdinfo=gd_info();
        if($gdinfo['FreeType Support'])
            return '';
        return t('yii','GD installed<br />FreeType support not installed');
    }
    return t('yii','GD not installed');
}

function getYiiVersion()
{
    $coreFile=dirname(__FILE__).'/../framework/YiiBase.php';
    if(is_file($coreFile))
    {
        $contents=file_get_contents($coreFile);
        $matches=array();
        if(preg_match('/public static function getVersion.*?return \'(.*?)\'/ms',$contents,$matches) > 0)
            return $matches[1];
    }
    return '';
}

/**
 * Returns a localized message according to user preferred language.
 * @param string message category
 * @param string message to be translated
 * @param array parameters to be applied to the translated message
 * @return string translated message
 */
function t($category,$message,$params=array())
{
    static $messages;

    if($messages === null)
    {
        $messages=array();
        if(($lang=getPreferredLanguage()) !== false)
        {
            $file=dirname(__FILE__)."/messages/$lang/yii.php";
            if(is_file($file))
                $messages=include($file);
        }
    }

    if(empty($message))
        return $message;

    if(isset($messages[$message]) && $messages[$message] !== '')
        $message=$messages[$message];

    return $params !== array() ? strtr($message,$params) : $message;
}

function getPreferredLanguage()
{
    if(isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) && ($n=preg_match_all('/([\w\-]+)\s*(;\s*q\s*=\s*(\d*\.\d*))?/',$_SERVER['HTTP_ACCEPT_LANGUAGE'],$matches)) > 0)
    {
        $languages=array();
        for($i=0; $i < $n; ++$i)
            $languages[$matches[1][$i]]=empty($matches[3][$i]) ? 1.0 : floatval($matches[3][$i]);
        arsort($languages);
        foreach($languages as $language=>$pref)
            return strtolower(str_replace('-','_',$language));
    }
    return false;
}

function getServerInfo()
{
    $info[]=isset($_SERVER['SERVER_SOFTWARE']) ? $_SERVER['SERVER_SOFTWARE'] : '';
    $info[]='<a href="http://www.yiiframework.com/">Yii Framework</a>/'.getYiiVersion();
    $info[]=@strftime('%Y-%m-%d %H:%M',time());

    return implode(' ',$info);
}

$result=1;  // 1: all pass, 0: fail, -1: pass with warnings

foreach($requirements as $i=>$requirement)
{
    if($requirement[1] && !$requirement[2])
        $result=0;
    else if($result > 0 && !$requirement[1] && !$requirement[2])
        $result=-1;
    if($requirement[4] === '')
        $requirements[$i][4]='&nbsp;';
}

