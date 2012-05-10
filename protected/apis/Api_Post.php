<?php
class Api_Post extends ApiBase
{
    public function timeline()
    {
        for ($i=0; $i<10; $i++) {
            $rows[] = array($i);
        }
        
        return $rows;
    }
}