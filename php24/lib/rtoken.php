<?php
class rtoken
{
    static $value;
    static $response;



    # добавить новый токен запросов (для api) в ограниченный список
    #
    static function init()
    {
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
    static function check(array $json = [])
    {
        if ( empty($_POST['rtoken']) )  return false;

        ui::$json   =   array_merge(ui::$json, $json);
        
        return true;
        
        return in_array( $_POST['rtoken'],  ($_SESSION['rtoken'] ?? []) );
    }


}