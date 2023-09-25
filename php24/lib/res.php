<?php
class res
{
    static $render;
    

    static function vars()
    {

        foreach( req::$wait as $i => $var )
        {
            unset(req::$wait[ $i ]);
            req::$wait[ $var ] = '';

            if ( $var == 'userList' )
            {
                req::$wait[ $var ]  =   user::list();
            }
        }

    }

    static function var($var, $val='')
    {
        if ( ! in_array($var, req::$wait)  )    return;

        $i  =   array_search($var, req::$wait);
        
        req::$wait[ $var ]  =   $val;
    }



    static function html()
    {
        if ( self::$render != 'html' )  return;
        
        // res::var('userList', 'sdvsdvsv');

        $vars   =   "";
        foreach( req::$wait as $k => $v )    $vars  .=  '<div id="' .$k. '">' .json_encode($v). '</div>'. "\n";
        
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