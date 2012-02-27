<?php
class TestController extends Controller
{
    public function actionTest1()
    {
//         var_dump(app()->session->isStarted);
//         session_start();
        var_dump(app()->session);
    }
}