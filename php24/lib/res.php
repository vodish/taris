<?php
class res
{
    static function json()
    {
        if ( req::$render != 'json' )  return;

    }

    static function html()
    {
        if ( req::$render != 'html' )  return;
        

    }


}