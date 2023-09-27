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
        if ( ! in_array(__FUNCTION__, req::$wait) )     return;
        if ( ! isset(pack::$pack) )                     return;
        
        self::$ret[__FUNCTION__]    =   pack::$pack->start;
    }

    static function packProject()
    {
        if ( ! in_array(__FUNCTION__, req::$wait) )     return;
        if ( ! isset(pack::$pack) )                     return;
        
        self::$ret[__FUNCTION__]    =   pack::$pack->project;
    }
    
    static function packBc()
    {
        if ( ! in_array(__FUNCTION__, req::$wait) )     return;
        if ( ! isset(pack::$pack) )                     return;

        self::$ret[__FUNCTION__]    =   pack::$pack->bc;
    }
    
    static function packTitle()
    {
        if ( ! in_array(__FUNCTION__, req::$wait) )     return;
        if ( empty(pack::$pack->start) )                return;


        $title  =   pack::$pack->list[ pack::$pack->start ]['name'];
        
        if ( pack::$pack->start != pack::$pack->project )
        {
            $title = pack::$pack->list[ pack::$pack->project ]['name']. ' / '. $title;
        }
        
        self::$ret[__FUNCTION__]    =   $title;
    }
    
    
    static function packHeap()
    {
        if ( ! in_array(__FUNCTION__, req::$wait) )     return;
        if ( ! isset(pack::$pack) )                     return;
        

        self::$ret[__FUNCTION__]  =   pack::$pack->heap;
    }
    

    static function packTree()
    {
        if ( ! in_array(__FUNCTION__, req::$wait) )     return;
        if ( ! isset(pack::$pack) )                     return;

        self::$ret[__FUNCTION__]  =   tree::array( pack::$pack->project );
    }
    
    static function packMenu()
    {
        if ( ! in_array(__FUNCTION__, req::$wait) )     return;
        if ( ! isset(pack::$pack) )                     return;

        self::$ret[__FUNCTION__]  =   pack::$pack->start;
    }
    
    static function lineHtml()
    {
        if ( ! in_array(__FUNCTION__, req::$wait) )     return;
        if ( ! isset(pack::$pack) )                     return;

        self::$ret[__FUNCTION__]  =   pack::$pack->start;
    }
    
    static function lineText()
    {
        if ( ! in_array(__FUNCTION__, req::$wait) )     return;
        if ( ! isset(pack::$pack) )                     return;


    }
    
    static function treeText()
    {
        if ( ! in_array(__FUNCTION__, req::$wait) )     return;
        if ( ! isset(pack::$pack) )                     return;


    }
    
    static function accessHtml()
    {
        if ( ! in_array(__FUNCTION__, req::$wait) )     return;
        if ( ! isset(pack::$pack) )                     return;


    }
    
    static function accessText()
    {
        if ( ! in_array(__FUNCTION__, req::$wait) )     return;
        if ( ! isset(pack::$pack) )                     return;
        
    }


    static function wait()
    {
        // return;

        self::$ret['wait'] = req::$wait;
        
    }


    


}