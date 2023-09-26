<?php
class res
{
    static $render;
    static $ret = array();
    

    static function userList()
    {
        if ( ! in_array('userList', req::$wait) )   return;

        self::$ret['userList']  =   user::list();
    }

    

    static function packStart()
    {
        if ( !pack::$start )    return;

        self::$ret['packStart'] =   pack::$start;
    }

    static function packBc()
    {}
    
    static function packTree()
    {}
    
    static function packHeap()
    {}
    
    static function packMenu()
    {}
    
    static function packTitle()
    {}
    
    static function packProject()
    {}
    
    static function lineHtml()
    {}
    
    static function lineText()
    {}
    
    static function treeText()
    {}
    
    static function accessHtml()
    {}
    
    static function accessText()
    {}


    



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

}