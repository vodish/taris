<?php
class req
{
    static $param;
    static $wait;

    

    # запрос главной страницы
    #
    static function fromMain()
    {
        if ( $_POST )               return;
        if ( url::$path != '/' )    return;
        
        # тип ответа
        #
        res::$render    =   'html';


        # ответ
        #
        req::$wait      =   ['userList'];
    }
    #
    # запрос страницы пака
    #
    static function fromPack()
    {
        if ( $_POST )                           return;
        if ( !isset(url::$level[0]) )           return;
        if ( ! is_numeric(url::$level[0]) )     return;
        if ( url::$level[0] < 1 )               return;
        
        # тип ответа
        #
        res::$render        =   'html';
        

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



    # запросы к api
    #
    static function fromApi()
    {
        if ( empty($_POST['rtoken']) )      return;
        if ( !isset(url::$level[0]) )       return;
        if ( url::$level[0] != 'api' )      return;

        # тип ответа
        #
        res::$render    =   "json";


        # главная страница
        #
        self::userList();
        self::userGetCode();
        self::userCheckCode();
        


        ui::vd($_POST);

        ui::vd(self::$wait);
        // ui::vd(self::$param);
        // ui::vd(self::$wait);
        die;
    }


    # идентификация запросов
    #
    private static function userList()
    {
        if ( ! isset($_POST['wait']) )                  return;
        if ( ! in_array('userList', $_POST['wait']) )   return;

        self::$wait   =   ['userList'];
    }


    private static function userGetCode()
    {
        if ( !isset($_POST['userGetCode']) )    return;
        if ( empty($_POST['email']) )           return;

        self::$param[]          =   'userGetCode';
        self::$param['email']   =   $_POST['email'];
    }

    private static function userCheckCode()
    {
        if ( !isset($_POST['userGetCode']) )    return;
        if ( empty($_POST['email']) )           return;

        self::$param[]          =   'userGetCode';
        self::$param['email']   =   $_POST['email'];
    }




}