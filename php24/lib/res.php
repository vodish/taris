<?php
class res
{
    static $render;




    static function html()
    {
        if ( self::$render != 'html' )  return;
        
        $vars   =   "";
        foreach( req::$wait as $k => $v )    $vars  .=  '<div id="' .$k. '">' .$v. '</div>'. "\n";
        
        
        $html   =   file_get_contents('index.html');
        $html   =   str_replace('</body>',  $vars. '</body>',  $html);

        die($html);
    }


    static function json()
    {
        if ( self::$render != 'json' )  return;

        header('Content-Type: application/json; charset=utf-8');


        echo  json_encode(req::$wait);
        
        die;
    }

}