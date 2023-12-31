<?php
class access
{
    private static $log = [];

    static $init    =   false;
    static $list    =   [];


    # json дерево для лога
    #
    static function log()
    {
        # пересортировать дерево как есть
        $list   =  array();
        $order  =  1;
        #
        foreach( self::$list as $pack => $li )
        {
            foreach( $li as $v )
            {
                # исключить настройку хозяина
                if ( $v['role'] == 'owner' )    continue;
                
                $v['order'] =   $order++;

                $list[ $pack ][]  =  $v;
            }
        }
        
        
        self::$log[]    =   json_encode($list, JSON_UNESCAPED_UNICODE);
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
        db::query("SELECT *  FROM `access`  WHERE `user` = " .db::v(user::$id). "  ORDER BY `order` ");
        #
        for(; $v = db::fetch(['int'=>['user', 'pack']]);  self::$list[ $v['pack'] ][] = $v );
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
        if ( empty(pack::$start) )              return;
        if ( @url::$level[1] != 'accessLink' )  return;
        if ( pack::denied('access') )           return;

        # лог для изменений
        self::log();


        # создать хеш
        #
        $ses    =   strtr( md5(time()) , ['0'=>'A','1'=>'B','2'=>'C','3'=>'D','4'=>'F','5'=>'G','6'=>'H','7'=>'I','8'=>'J','9'=>'K'] );


        # если уже есть в настройках
        #
        foreach( self::$list[ pack::$start ] ?? []  as  $v )
        {
            if ( $v['role'] == 'link' )
            {
                $hash   =   $v;
                break;
            }
        }
        #
        # или добавить
        #
        if ( !isset($hash) )
        {
            self::$list[ pack::$start ][]  = $hash =  array(
                'user'      =>  user::$id,
                'pack'      =>  pack::$start,
                'role'      =>  'link',
                'email'     =>  substr( $ses, 0, 4 ),
                'comment'   =>  "    # доступ по ссылке",
            );
        }


        // ui::vd(self::$list);
        // ui::vd($hash);
        // die;


        # вернуть публичную ссылку
        #
        res::$ret['href']   =   '/' .pack::$start. '/' .$hash['email'];
        #
        url::parse( res::$ret['href'] );
        req::$wait[]  = 'packTree';
        


        # записать в базу новый хеш
        #
        self::dbSave();

    }






    # проверка "поделиться ссылкой"
    #
    static function checkLink()
    {
        $hash   =   url::$level[1] ?? null;

        foreach( self::$list[ pack::$start ] ?? []  as  $v )
        {
            if ( $v['role'] == 'link'  && $v['email'] == $hash )
            {
                return true;
            }
        }
        
        return  false;
    }




    # сохранить права
    #
    static function upd()
    {
        if ( empty(pack::$start) )              return;
        if ( !isset(req::$param['access']) )    return;
        if ( pack::denied('access') )           return;

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
        $list   =   json_decode(self::$log[1], true);
        #
        foreach( $list as $arr )
        {
            foreach( $arr as $access )
            {
                foreach($access as &$v)   $v = db::v($v);

                $rows[] =   "(".  implode(',', $access).  ")";
            }
        }
        


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
                ," .db::v(author::$id). "
                ," .db::v(author::$email). "
                ," .db::v('access'). "
                ," .db::v(null). "
                ," .db::v(self::$log[1]). "
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