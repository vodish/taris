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
        $order  =  1;
        foreach( self::$list as $pack => &$list )
        {
            foreach( $list as $k => &$v )
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
            'role'      =>  'owner',
            'email'     =>  user::$email,
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
                    $text .=  '    '. str_pad($v['role'].':', 8).  $v['email']. ($v['comment'] ? $v['comment'] : '').  "\n"; 
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
        $content    =   req::$param['access'];
        $content    =   strtr($content, ["\r"=>'']);
        $content    =   explode("\n", $content);
        #
        $pack       =   null;
        self::$list =   array();
        #
        #
        foreach( $content as $str )
        {
            if ( $row = self::parse($str, $pack) )
            {
                self::$list[ $pack ][] = $row;
            }
        }

        
        # обновить права
        #
        pack::setAccess();


        # сохранить в базе
        #
        self::dbSave();
    }



    # распарсить строку
    #
    private static function parse($str, &$pack)
    {
        # определение пачки
        if ( preg_match("#^\S.+\s(\d+)$#", $str, $m)  && isset($m[1]) )
        {
            $pack =  intval($m[1]);
        }
        #
        # настройка
        elseif ( preg_match("#\s(\S+)\s+(\S+)(.*)#", $str, $m)  && isset($m[2]) )
        {
            $role       =   mb_strtolower( strtr($m[1], [":"=>""]) );
            $email      =   $m[2];
            $comment    =   $m[3] ??  '';
            
            if ( $role == 'owner' )      return false;

            $row        =   array(
                'user'      =>  user::$id,
                'pack'      =>  $pack,
                'role'      =>  $role,
                'email'     =>  $email,
                'comment'   =>  $comment,
                'order'     =>  0,
            );
            return $row;
        }


        return false;
    }




    # сохранить записи в базу
    #
    private static function dbSave()
    {
        # текущее дерево
        #
        self::log();

        
        if ( self::$log[0] == self::$log[1] )   return;
        if ( !isset(self::$log[1]) )            return;
        
        
        


        # подготовить sql записи дерева
        #
        $rows   =   array();
        #
        foreach( self::$list as $list )
        {
            foreach( $list as $access )
            {
                foreach($access as &$v)   $v = db::v($v);

                $rows[] =   "(".  implode(',', $access).  ")";
            }
        }
        #
        #
        // ui::vd( user::$prefix );
        // ui::vd( self::$list );
        // ui::vd( $rows );
        // die;
        // ui::vd(self::$log);
        // ui::vdd('сохранить в базе');
        


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
                ," .db::v('access'). "
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
            FROM    `access`
            WHERE   `user` = " .db::v(user::$id). "
        ");
        #
        #
        if ( empty($rows) )     return;
        #
        #
        db::query("
            INSERT INTO `access` (
                 `user`
                ,`pack`
                ,`role`
                ,`email`
                ,`comment`
                ,`order`
            )
            VALUES
            ".  implode("\n,", $rows).  "
        ");

    }




}