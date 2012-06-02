<?php
class ApiController extends Controller
{
    public function actionIndex()
    {
        header('Content-Type: application/json; charset=utf-8');
        AppApi::setDataFormat(AppApi::FORMAT_JSON);
        $api = new AppApi();
        $api->run();
    }
    
    public function actionJson()
    {
        header('Content-Type: application/json; charset=utf-8');
        AppApi::setDataFormat(AppApi::FORMAT_JSON);
        $api = new AppApi();
        $api->run();
    }
    
    public function actionJsonp()
    {
        header('Content-Type: application/javascript; charset=utf-8');
        AppApi::setDataFormat(AppApi::FORMAT_JSONP);
        $api = new AppApi();
        $api->run();
    }
    
    public function actionXml()
    {
        header('Content-Type: application/xml; charset=utf-8');
        AppApi::setDataFormat(AppApi::FORMAT_XML);
        $api = new AppApi();
        $api->run();
    }
}