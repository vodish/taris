<?php
class res
{
    static $render;


    static function json()
    {
        if ( res::$render != 'json' )  return;

    }

    static function html()
    {
        if ( res::$render != 'html' )  return;
        

    }
}