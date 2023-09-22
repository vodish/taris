<?php
class res
{
    static $render;


    
    static function json()
    {
        if ( self::$render != 'json' )  return;

    }

    static function html()
    {
        if ( self::$render != 'html' )  return;
        

    }


}