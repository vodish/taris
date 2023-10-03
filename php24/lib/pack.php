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


    # значения по-умолчанию
    #
    static function clear()
    {
        
        self::$start    =   null;
        self::$list     =   [];
        self::$parent   =   [];
        self::$bc       =   [];
        self::$heap     =   [];
        self::$project  =   null;
        self::$user     =   null;
        self::$file     =   null;
    }



    static function init( $start = null )
    {
        # конструктор
        #
        self::clear();
        #
        $start  =   $start  ??  req::$param['pack']  ??  null;
        #        
        if ( empty($start) )    return;


        # достать user.id из pack.id
        #
        $ulen   =   substr($start, 0, 1);           # длина user.id
        $user   =   substr($start, 1, $ulen);       # id пользака
        
        

        # получить хозяина
        #
        self::$user =   db::one("SELECT *  FROM `user`  WHERE `id` = "  .db::v((int)$user)." ");
        #
        if ( empty(self::$user) )   return;



        # получить все пачки хозяина
        #
        db::query("SELECT *  FROM `pack`  WHERE `user` = " .self::$user['id']. " ORDER BY `order`");
        #
        #
        while ( $v = db::fetch(['int'=>['id', 'parent', 'is_project', 'order', 'user', 'file']]) )
        {
            self::$list[ $v['id'] ] =   $v;
            self::$parent[ $v['parent'] ][] =   $v['id'];
        }
        
        # не найдена пачка
        #
        if ( empty(self::$list) )   return;
        
        ui::vd(self::$list);

        # получить права пачек
        #






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