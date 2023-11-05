<?php
class rtoken
{
    static $value;


    # добавить ртокен для api запросов
    #
    static function init()
    {
        $_SESSION['rtoken'][]   =   self::$value =   md5( session_id(). time() );
        #
        for($c=count($_SESSION['rtoken']);  $c > 15;  $c--)     array_shift($_SESSION['rtoken']);

        
        return  res::$ret['rtoken']  =  self::$value;
    }


    # перевыпустьить ртокен
    #
    static function refresh()
    {
        if ( HTTP_HOST == 'k.taris24' )     return  res::$ret['rtoken']  =  HTTP_HOST;
        if ( !isset($_POST['rtoken']) )     return;
        if ( empty($_SESSION['rtoken']) )   return;

        # удалить старый
        $key    =   array_search($_POST['rtoken'], $_SESSION['rtoken']);
        unset($_SESSION['rtoken'][ $key ]);
        
        
        return  res::$ret['rtoken']  =  self::init();
    }



    # проверить ртокен
    #
    static function check()
    {
        if ( HTTP_HOST == 'k.taris24' )         return true;
        if ( empty(req::$param['rtoken']) )     return false;
        if ( empty($_SESSION['rtoken']) )       return false;
        

        return in_array( req::$param['rtoken'], $_SESSION['rtoken'] );
    }


}