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
    static function clear()
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
        $user  =   db::one("SELECT *  FROM `user`  WHERE `id` = "  .db::v((int)$user)." ");
        db::cast($user, ['int'=>['id', 'start', 'counter']]);
        #
        if ( empty($user) )   return;



        # получить все пачки хозяина
        #
        db::query("SELECT *  FROM `pack`  WHERE `user` = " .$user['id']. " ORDER BY `order`");
        #
        #
        while ( $v = db::fetch(['int'=>['id', 'project', 'order', 'user', 'file']]) )
        {
            self::$list[ $v['id'] ] =   $v;
            self::$tree[ $v['project'] ][] =   $v['id'];
        }
        
        # не найдена пачка
        #
        if ( empty(self::$list) )   return;
        




        # определения
        #
        self::$start    =   $start  =  (int) $start;
        self::$project  =   self::$list[ self::$start ]['project'];
        user::$id       =   $user['id'];
        user::$email    =   $user['email'];
        user::$start    =   $user['start'];
        user::$counter  =   $user['counter'];
        self::$file     =   self::$list[ self::$start ]['file'];
        


        
        
        # крошки проекта
        #
        while ( isset( self::$list[ $start ] ) )
        {
            self::$bc[] =   $start;
            $start  =   self::$list[ $start ]['project'];
        }
        


        
        # дерево проекта - на отдаче данных (packHeap - куча не нужна, сделать без неё)
        #
        // foreach( self::$tree[ self::$project ] as &$v )
        // {
        //     $v  =   array(
        //         'id'    =>  self::$list[ $v ]['id'],
        //         'space' =>  self::$list[ $v ]['space'],
        //         'name'  =>  self::$list[ $v ]['name'],
        //     );
        // }

        # крошки
        #
        ui::vd( self::$start );
        ui::vd( self::$project );
        ui::vd( self::$bc );
        ui::vd( self::$_user );
        ui::vd( self::$file );
        ui::vd( self::$tree );
        //ui::vd( self::$list );
        die;



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