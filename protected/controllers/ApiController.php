<?php
class ApiController extends Controller
{
    public function actionIndex()
    {
        AppApi::setDataFormat(AppApi::FORMAT_JSON);
        $api = new AppApi();
        $api->run();
    }
    
    public function actionJson()
    {
        AppApi::setDataFormat(AppApi::FORMAT_JSON);
        $api = new AppApi();
        $api->run();
    }
    
    public function actionJsonp()
    {
        AppApi::setDataFormat(AppApi::FORMAT_JSONP);
        $api = new AppApi();
        $api->run();
    }
    
    public function actionXml()
    {
        AppApi::setDataFormat(AppApi::FORMAT_XML);
        $api = new AppApi();
        $api->run();
    }
}