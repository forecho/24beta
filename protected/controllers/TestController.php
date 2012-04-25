<?php

class TestController extends Controller
{
    public function actionTest1()
    {
        exit;
        $result = FilterKeyword::updateCacheFile();
        var_dump($result);
        exit;
        echo time();
        exit;
        phpinfo();
        exit;
        
        $a = array(
        	array('age'=>20, 'name'=>'asdfxxx'),
        	array('age'=>21, 'name'=>'sdfgbbb'),
        	array('age'=>22, 'name'=>'dfghdddd')
        );
        
        $b = array_walk($a, function(&$item){
    $item = $item['name'];
});
        print_r($a);
        
        exit;
        $html = 'sadf<fieldset><legend>title></legend>asdfasdfasdf</fieldset>content';
        $pattern = '/<fieldset>.*<\/fieldset>/is';
        $content = preg_replace($pattern, '', $html);
        
        var_dump($content);
        exit;
        
//         var_dump(app()->session->isStarted);
//         session_start();
        var_dump(app()->session);
    }

    public function actionWeibo()
    {
        exit;
        $appKey = '456860706';
        $appSecert = '19168ffef668231aa22f74683d3d18e7';
        
        $url = 'https://api.weibo.com/2/statuses/user_timeline.json';
        $params = array(
            'source' => $appKey,
            'screen_name' => '暴走漫画',
            'count' => 20,
            'trim_user' => 1,
        );
        $fetch = new CdCurl();
        $fetch->ssl()->get($url, $params);
        $data = $fetch->rawdata();
        
        echo $fetch->errno();
        echo $fetch->error();
        echo '<br />';
        print_r(json_decode($data));
    }
}