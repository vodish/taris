<?php
class req
{
    static $param;
    static $wait;

    static $render;


    static function forMain()
    {
        if ( $_POST )               return;
        if ( url::$path != '/' )    return;
        
        # тип ответа
        #
        req::$render    =   'html';


        # ответ
        #
        req::$wait      =   ['userLst'];
    }


    
    static function forPack()
    {
        if ( $_POST )                           return;
        if ( !isset(url::$level[0]) )           return;
        if ( ! is_numeric(url::$level[0]) )     return;
        if ( url::$level[0] < 1 )               return;
        
        # тип ответа
        #
        req::$render        =   'html';
        

        # зависимости и операции
        #
        req::$param['pack'] =   url::$level[0];
        

        # ответ
        #
        req::$wait[]        =   'pack';

        if      ( !isset(url::$level[1]) )      req::$wait[]  =   'lineHtml';
        elseif  ( url::$level[1] == 'line' )    req::$wait[]  =   'lineText';
        elseif  ( url::$level[1] == 'tree' )    req::$wait[]  =   'treeText';
        elseif  ( url::$level[1] == 'access' )  req::$wait    =   array_merge(req::$wait, ['accessArray', 'accessText']);
        else                                    req::$wait[]  =   '404';
        
    }




    static function check()
    {
        if ( empty($_POST['rtoken']) )      return;
        if ( !isset(url::$level[0]) )       return;
        if ( url::$level[0] != 'api' )      return;

        # тип ответа
        #
        req::$render    =   "json";



        ui::vd(req::$param);
        ui::vd(req::$wait);
        die;
    }



}