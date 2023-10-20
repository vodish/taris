<?php
class access
{
    private static $log = [];

    static $init  =  false;
    static $list  =  [];
    


    # json дерево для лога
    #
    static function log()
    {

        # пересортировать дерево как есть
        $order = 0;
        foreach( self::$list as $pack => $list )
        {
            foreach( $list as $k => $v )
            {
                $v['order'] =   $order++;

                # удалить роль хозяина из настроек
                if ( $v['role'] == 'owner' )    unset(self::$list[ $pack ][ $k ]);
            }
        }
        

        self::$log[]    =   json_encode(self::$list, JSON_UNESCAPED_UNICODE);
    }





    static function dbInit()
    {
        if ( empty(user::$id)   )     return;
        if ( self::$init        )     return;
        
        # инициализация
        self::$init  =  true;

        # хозяин профиля
        #
        self::$list[ user::$start ][]  =  array(
            'user'      =>  user::$id,
            'pack'      =>  user::$start,
            'email'     =>  user::$email,
            'role'      =>  'owner',
            'comment'   =>  '',
        );
        #
        # права из базы
        #
        db::query("SELECT *  FROM `access`  WHERE `user` = " .db::v(user::$id). "  ORDER BY `order`" );
        #
        for(; $v = db::fetch();  self::$list[ $v['pack'] ][] = $v );
        
    }
    




    # список прав для пачки как текст
    #
    static function asText()
    {
        $text  =  '';
        
        foreach( pack::$tree as $tree )
        {
            foreach( $tree as $pack )
            {
                if ( !isset(self::$list[ $pack['id'] ]) )   continue;

                $text .=  $pack['name'].  '   '.  $pack['id'].  "\n";

                foreach( self::$list[ $pack['id'] ] as $v )
                {
                    $text .=  '    '. str_pad($v['role'].':', 8).  $v['email'].  "\n"; 
                }
                
                $text .=  "    \n";
            }
        }


        
        return  substr($text, 0, -1);
    }



    # добавить ссылку
    #
    static function link()
    {
        if ( empty(pack::$start)                )   return;
        if ( @url::$level[1] != 'access-link'   )   return;


        ui::vdd( req::$param );
        ui::vdd( url::$level );

        die;
    }






    # сохранить права
    #
    static function upd()
    {
        if ( empty(pack::$start)            )   return;
        if ( !isset(req::$param['access'])  )   return;

        # логировать
        #
        self::log();

        
        # распарсить новые права
        #
        $explode    =   explode("\n", req::$param['access']);
        $list       =   array();
        $pack       =   null;

        foreach( $explode as $str )
        {
            $row  =   self::parse($str, $pack);
            
            if ( $pack && $row )
            {
                $list[ $pack ][] = $row;
            }

        }

        // ui::vd( req::$param );
        ui::vd( $pack, 1 );
        die;



        # сохранить в базе
        #
        self::dbSave();
    }



    private static function parse($str, &$pack)
    {
        ui::vd($str);

        # пачка
        if ( preg_match("#^\S+ +\d+$#", $str, $m) )
        {
            ui::vd($m);
            die;
            return  $pack =  $m;
        }
        #
        # настройка
        elseif ( preg_match_all("#(?<=\s)\S+#", $str, $m) )
        {
            ui::vd($m);
        }

        /*
        pack.name  123
            Owner   vodish@yandex.ru
            View    @psw.ru
            Editor  @psw.ru
            View    public
            View    https://taris.pro/link/53a71acac187833047fef7f6ff16250e
            
            
        pack.name  123
            Owner   vodish@yandex.ru    # комментарий какой-то
            View    @psw.ru             # комментарий какой-то
            View    public
        */
    }




    # сохранить записи в базу
    #
    private static function dbSave()
    {
        # текущее дерево
        #
        self::log();
        #
        #
        if ( !isset(self::$log[1]) )            return;
        if ( self::$log[0] == self::$log[1] )   return;


        ui::vdd('сохранить в базе');


        # подготовить sql записи дерева
        #
        foreach( pack::$tree as $list )
        {
            foreach( $list as $pack )
            {
                if ( $pack['project'] == 0 )    continue;
                
                foreach($pack as &$v)  $v = db::v($v);
                
                $rows[] =   "(".  implode(',', $pack).  ")";
            }
        }
        #
        #
        // ui::vd( user::$prefix );
        // ui::vd( $rows );
        // die;
        


        # сохранить в лог
        #
        db::query("
            INSERT INTO `log` (
                 `user`
                ,`author`
                ,`author_email`
                ,`target`
                ,`row`
                ,`json`
            )
            VALUES (
                 " .db::v(user::$id). "
                ," .db::v(0). "
                ," .db::v('@'). "
                ," .db::v('tree'). "
                ," .db::v(null). "
                ," .db::v(self::$log[0]). "
            )
        ");
        #
        #
        # обновить дерево
        #
        db::query("
            DELETE
            FROM    `pack`
            WHERE   `user` = " .db::v(user::$id). " AND `project` != 0
        ");
        #
        #
        if ( empty($rows) )     return;
        #
        #
        db::query("
            INSERT INTO `pack` (
                 `user`
                ,`id`
                ,`project`
                ,`space`
                ,`name`
                ,`order`
                ,`file`
            )
            VALUES
            ".  implode("\n,", $rows).  "
        ");

    }




}