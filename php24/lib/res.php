<?php
class res
{
    static $render;
    static $ret  =  array();
    

    
    static function html()
    {
        if ( self::$render != 'html' )  return;
        
        $vars   =   "";
        foreach( self::$ret as $k => $v )    $vars  .=  '<div id="' .$k. '">' .json_encode($v). '</div>'. "\n";
        
        $html   =   file_get_contents('index.html');
        $html   =   str_replace('</body>',  $vars. '</body>',  $html);

        die($html);
    }


    static function json()
    {
        if ( self::$render != 'json' )  return;

        // ui::vd(req::$wait);
        // ui::vd(req::$param);
        // ui::vd(self::$ret);

        header('Content-Type: application/json; charset=utf-8');

        die( json_encode(self::$ret) );
    }









    static function userList()
    {
        if ( ! in_array(__FUNCTION__, req::$wait) )     return;


        self::$ret['userList']  =   user::list();
    }

    

    static function packStart()
    {
        if ( ! pack::$start )                           return;
        if ( ! in_array(__FUNCTION__, req::$wait) )     return;

        self::$ret['packStart'] =   pack::$start;
    }

    static function packBc()
    {
        if ( ! pack::$start )                           return;
        if ( ! in_array(__FUNCTION__, req::$wait) )     return;


        // self::$ret['packStart'] =   pack::$start;
    }
    
    static function packTree()
    {
        if ( ! pack::$start )                           return;
        if ( ! in_array(__FUNCTION__, req::$wait) )     return;

        // self::$ret['packStart'] =   pack::$start;
    }
    
    static function packHeap()
    {
        if ( ! pack::$start )                           return;
        if ( ! in_array(__FUNCTION__, req::$wait) )     return;

        // self::$ret['packStart'] =   pack::$start;
    }
    
    static function packMenu()
    {
        if ( ! pack::$start )                           return;
        if ( ! in_array(__FUNCTION__, req::$wait) )     return;

        // self::$ret['packStart'] =   pack::$start;
    }
    
    static function packTitle()
    {
        if ( ! pack::$start )                           return;
        if ( ! in_array(__FUNCTION__, req::$wait) )     return;

        // self::$ret['packTitle'] =   pack::$start;
    }
    
    static function packProject()
    {
        if ( ! pack::$start )                           return;
        if ( ! in_array(__FUNCTION__, req::$wait) )     return;

        // self::$ret['packTitle'] =   pack::$start;
    }
    
    static function lineHtml()
    {
        if ( ! pack::$start )                           return;
        if ( ! in_array(__FUNCTION__, req::$wait) )     return;


    }
    
    static function lineText()
    {
        if ( ! pack::$start )                           return;
        if ( ! in_array(__FUNCTION__, req::$wait) )     return;


    }
    
    static function treeText()
    {
        if ( ! pack::$start )                           return;
        if ( ! in_array(__FUNCTION__, req::$wait) )     return;


    }
    
    static function accessHtml()
    {
        if ( ! pack::$start )                           return;
        if ( ! in_array(__FUNCTION__, req::$wait) )     return;


    }
    
    static function accessText()
    {
        if ( ! pack::$start )                           return;
        if ( ! in_array(__FUNCTION__, req::$wait) )     return;


    }


    


}