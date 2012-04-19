<?php

class TestController extends Controller
{
    public function actionTest1()
    {
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
}