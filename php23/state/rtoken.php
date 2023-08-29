<?php
class rtoken
{
    static $value;
    static $response;



    # определение токена для одноразовых запросов к api
    #
    static function init()
    {
        if ( !isset($_POST['rtoken']) )     return;


        # создать новый токен
        # почистить историю токенов
        #
        $_SESSION['rtoken'][]   =   self::$value =   md5( session_id(). time() );
        #
        for($c=count($_SESSION['ft']);  $c > 10;  $c--)     array_shift($_SESSION['ft']);
    }




    # проверить токен
    #
    static function check($json='{}')
    {
        if ( in_array( $_POST['rtoken'],  ($_SESSION['rtoken'] ?? []) ) )   return true;

        self::$response =   $json;

        return false;
    }

}