<?php
class TagController extends Controller
{
    public function actionPosts($name)
    {
        echo urldecode($name);
    }
}