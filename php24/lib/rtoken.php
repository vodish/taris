<?php
class rtoken
{
    static $value;
    static $check;


    # проверить ртокен
    #
    static function check()
    {
        if ( self::$check !== null )    return self::$check;

        $rtoken     =   $_POST['rtoken'] ?? null;
        $session    =   $_SESSION['rtoken'] ?? [];
        

        return self::$check  =  in_array($rtoken, $session);
    }


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
        if ( !self::check() )  return;

        # удалить старый
        $key    =   array_search($_POST['rtoken'], $_SESSION['rtoken']);
        unset($_SESSION['rtoken'][ $key ]);
        
        
        return  res::$ret['rtoken']  =  self::init();
    }

    
}