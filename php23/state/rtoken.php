<?php
class rtoken
{
    static $value;
    static $response;



    # определение токена для одноразовых запросов к api
    #
    static function init()
    {
        //if ( !isset($_POST['rtoken']) )     return;


        # создать новый токен
        # почистить историю токенов
        #
        $_SESSION['rtoken'][]   =   self::$value =   md5( session_id(). time() );
        #
        for($c=count($_SESSION['rtoken']);  $c > 10;  $c--)     array_shift($_SESSION['rtoken']);

        return rtoken::$value;
    }


    # удалить токен
    #
    static function drop()
    {
        if ( !isset($_POST['rtoken']) )     return;
        if ( empty($_SESSION['rtoken']) )   return;

        $key    =   array_search($_POST['rtoken'], $_SESSION['rtoken']);

        unset($_SESSION['rtoken'][ $key ]);

        return rtoken::init();
    }


    # проверить токен
    #
    static function check()
    {
        return in_array( $_POST['rtoken'],  ($_SESSION['rtoken'] ?? []) );
    }

}