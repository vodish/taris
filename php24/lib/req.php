<?php
class req
{
    static $param;
    static $wait;


    static function forMain()
    {
        if ( url::$path != '/' )    return;

        req::$wait  =   ['userLst'];
    }

    static function forPack()
    {
        if ( !isset(url::$level[0]) )           return;
        if ( ! is_numeric(url::$level[0]) )     return;
        if ( url::$level[0] < 1 )               return;

        
        req::$param['pack'] =   url::$level[0];
        req::$wait[]        =   'pack';

        if      ( !isset(url::$level[1]) )      req::$wait[]  =   'lineHtml';
        elseif  ( url::$level[1] == 'line' )    req::$wait[]  =   'lineText';
        elseif  ( url::$level[1] == 'tree' )    req::$wait[]  =   'treeText';
        elseif  ( url::$level[1] == 'access' )  req::$wait    =   array_merge(req::$wait, ['accessArray', 'accessText']);
        
    }




    static function check()
    {
        
        ui::vd(req::$param);
        ui::vd(req::$wait);
        die;
    }



}