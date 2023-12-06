<?php
class file
{
    static $init    =   false;

    static $id;
    static $mode    =   "html";


    static function dbInit()
    {
        if ( empty(pack::$file) )   return;
        if ( self::$init        )   return;
        
        # инициализация прошла
        self::$init =   true;

        
        # получить все записи из базы
        #
        $file   =   db::one("SELECT  *  FROM  `file`  WHERE  `id` = " .db::v(pack::$file) );
        db::cast($file, ['int'=>['id']]);
        #
        #
        self::$id       =   $file['id'];
        self::$mode     =   $file['mode'];
        
    }
}