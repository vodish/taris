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
        # проверить дубли ид и принадлежность к пользователю
        #
        
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
        # остальные настроенные права из базы
        #
        db::query("SELECT *  FROM `access`  WHERE `user` = " .db::v(user::$id) );
        #
        for(; $v = db::fetch();  self::$list[ $v['pack'] ][] = $v );
        
    }
    



    # список прав для пачке как html
    #
    static function asHtml($packId)
    {
        $access =   self::$list[ $packId ] ?? array();
        $html   =   '';
        
        if ( !$access )     return '';

        foreach( $access as $email => $v )
        {
            $html   =   '';
            $html   .=  '<pre>' .$email. ':</pre>';
            $html   .=  '<pre>    role: ' .$v['role']. '</pre>';
            $html   .=  $v['comment'] ? '<pre>    comment: ' .$v['comment']. '</pre>': '';
            $html   .=  '<br />';
        }

        return $html;
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

                $text   .=  $pack['name'].  '   '.  $pack['id'].  "\n";

                foreach( self::$list[ $pack['id'] ] as $v )
                {
                    $text   .=  '    '. str_pad($v['role'].':', 8).  $v['email']; 
                }
                
            }

        }
        
        // ui::vd( $text );


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
        // if ( $v['role'] == 'Owner' )    continue;
        // $is_email   =   filter_var($email, FILTER_VALIDATE_EMAIL);
        // $text   .=  $email. ":\n";
        // $text   .=  '    role: '. $v['role']. "\n";
        // $text   .=  empty($v['comment']) ?  '' : '    comment: '. $v['comment']. "\n";
        // $text   .=  $is_email ?             '' : '    link: '. url::site(). '/'. $packId. '?hash='. $email. "\n";
        // $text   .=  $v['updated'] ?         '' : '    updated: '. $v['updated']. "\n";
        // $text   .=  "\n";

        return $text;
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


        ui::vd( req::$param );
        die;



        # сохранить в базе
        #
        self::dbSave();
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