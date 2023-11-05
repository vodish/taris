<?php
class res
{
    static $render;
    static $ret     =  array();
    


    static function html()
    {
        if ( self::$render != 'html' )  return;
        
        # выдать ртокен
        self::$ret['rtoken']    =   rtoken::init();
        #
        # добавить сео контент
        $seo   =   '';
        foreach( self::$ret as $k => $v )    $seo  .=  '<div class="seo" id="' .$k. '">' .json_encode($v). '</div>'. "\n";
        
        # отдать бандл
        #
        $html   =   file_get_contents('index.html');
        $html   =   preg_replace("#<.+\"seo\".+>\r?\n?#", $seo, $html);

        header('Content-Type: text/html; charset=UTF-8');
        die($html);
    }


    static function json()
    {
        if ( self::$render != 'json' )  return;

        # перевыпустить ртокен
        self::$ret['rtoken']    =   rtoken::refresh();

        header('Content-Type: application/json; charset=utf-8');

        die( json_encode(self::$ret) );
    }


}