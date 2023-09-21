<?php
class ans
{
    static $render;


    static function json()
    {
        if ( ans::$render != 'json' )  return;

    }

    static function html()
    {
        if ( ans::$render != 'html' )  return;
        

    }
}