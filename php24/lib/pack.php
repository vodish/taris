<?php
class pack
{
    static $start;
    static $list;
    static $parent;
    static $bc;
    static $heap;
    static $project;
    static $user;
    static $file;


    static function init( $start = null )
    {
        # значения по-умолчанию
        #
        self::$start    =   null;
        self::$list     =   [];
        self::$parent   =   [];
        self::$bc       =   [];
        self::$heap     =   [];
        self::$project  =   null;
        self::$user     =   null;
        self::$file     =   null;


        # конструктор
        #
        $start  =   $start  ??  req::$param['pack'] ?? null;
        #        
        if ( empty($start) )    return;

        

        # получить все пачки пользователя
        #
        $start  =   intval($start);
        #
        #
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
        
        # не найдена пачка
        #
        if ( empty(self::$list) )
        {
            return;
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
    
            self::toHeap($pack);
        }
        

        # определения
        #
        self::$start    =   $start;
        self::$project  =   self::$bc[0] ?? $start;
        self::$bc       =   array_reverse( self::$bc );
        self::$user     =   self::$list[ $start ]['user'];
        self::$file     =   self::$list[ $start ]['file'];
        

        # добавить в крошки открытую пачку
        #
        if ( $start != self::$project )
        {
            self::$bc[] =   $start;
            self::toHeap( self::$list[ $start ] );
        }
        
    }


    

    static function toHeap( $pack )
    {
        self::$heap[ $pack['id'] ]  =   array(
            'id'    =>  $pack['id'],
            'name'  =>  $pack['name'],
        );
    }

}