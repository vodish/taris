<?php
class pack
{
    static $start;
    static $project;
    static $user;
    
    static $list    =   array();
    static $parent  =   array();
    static $bc      =   array();
    

    # получить все пачки пользователя
    #
    static function dbInit($start)
    {
        db::query("
            SELECT
                *
            FROM
                `pack`
            WHERE
                `user` = (SELECT `user`  FROM `pack`  WHERE `id` = " .db::v($start). ")
            ORDER BY
                `order`
        ");
        #
        #
        while ( $v = db::fetch() )
        {
            db::cast($v, array('int'=>['id', 'parent', 'is_project', 'order']));
            
            self::$list[ $v['id'] ] =   $v;
            self::$parent[ $v['parent'] ][] =   $v['id'];
        }



        # определить крошки проекта
        # определить текущий проект
        #
        $packId =   $start;
        #
        while( isset(self::$list[ $packId ]) )
        {
            $pack       =   self::$list[ $packId ];
            $packId     =   $pack['parent'];

            if ( !$pack['is_project'] )     continue;
            
            self::$bc[] =   $pack['id'];
        }
        #
        #
        self::$project  =   self::$bc[0];
        self::$start    =   $start;
        self::$user     =   self::$list[ $start ]['user'];


    }
    
}