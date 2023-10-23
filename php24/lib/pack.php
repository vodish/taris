<?php
class pack
{
    static $start;
    static $project;
    static $list;
    static $tree;
    static $bc;
    static $file;
    

    # значения по-умолчанию
    #
    private static function reset()
    {
        self::$start    =   null;
        self::$project  =   null;
        self::$list     =   [];
        self::$tree     =   [];
        self::$bc       =   [];
        self::$file     =   null;
    }


    # инициализация пачек
    #
    static function dbInit( $start = null )
    {
        # cбросить состояние
        self::reset();
        #
        $start  =   $start  ??  req::$param['pack']  ??  null;
        #        
        if ( empty($start) )    return;



        # распарсить ид пачки
        # кодировка в первом знаке - длина user.id (123456789ABC)
        #
        $ulen       =   substr( $start,  0,  1 );           # количесто знаков в user.id
        $user       =   substr( $start,  1,  $ulen );       # user.id
        $prefix     =   substr( $start,  0,  $ulen + 1 );   # префикс пользака
        
        

        # получить хозяина
        #
        $user       =   db::one("SELECT *  FROM `user`  WHERE `id` = "  .db::v((int)$user)  );
        #
        db::cast($user, ['int'=>['id', 'start']]);
        if ( empty($user) )   return;


        # получить права
        #
        access::dbInit();
        


        # получить все пачки хозяина
        #
        db::query("
            SELECT
                *
            FROM
                `pack`
            WHERE
                `user` = " .$user['id']. "
            ORDER BY
                 `project`
                ,`order`
        ");
        #
        while ( $v = db::fetch(['int'=>['id', 'project', 'space', 'order', 'user', 'file']]) )
        {
            $counter[]  =   (int) substr( strval($v['id']),  $ulen + 1 );

            self::$list[ $v['id'] ] =   $v;
            self::$tree[ $v['project'] ][] =   $v;
        }
        #
        # не найдена пачка
        #
        if ( empty(self::$list) )   return;
        

        

        # базовые определения
        #
        self::$start    =   $start  =  (int) $start;
        self::$project  =   self::$list[ self::$start ]['project'];
        user::$id       =   $user['id'];
        user::$email    =   $user['email'];
        user::$start    =   $user['start'];
        user::$prefix   =   $prefix;
        user::$counter  =   max($counter);
        self::$file     =   self::$list[ self::$start ]['file'];
        

        
        # крошки проекта
        #
        while ( isset( self::$list[ $start ] ) )
        {
            self::$bc[] =   $start;
            $start  =   self::$list[ $start ]['project'];
        }
        
    }



    static function id()
    {
        
    }
    


}