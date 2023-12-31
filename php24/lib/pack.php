<?php
class pack
{
    static $start;
    static $project;
    static $list;
    static $tree;
    static $bc;
    static $file;

    static $ui;
    static $isProject;
    static $menu  =  [];


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


        



        # получить все пачки хозяина
        #
        db::query("SELECT *  FROM `pack`  WHERE `user` = " .$user['id']. "  ORDER BY `project`, `order` ");
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
        


        # меню и права
        #
        self::setAccess();
        

        # поделиться ссылкой
        #
        if ( access::checkLink() )
        {
            req::$wait[]  = 'lineHtml';
        }
        
    }
    


    # проверить парава пользователя на крошках
    #
    static function setAccess()
    {
        author::dbInit();
        access::dbInit();


        # пройти по крошкам
        #
        $bc  =   array_reverse( self::$bc );
        #
        foreach( $bc as $id )
        {
            # пройти по настрокам доступа для пачек в крошках
            #
            foreach( access::$list[ $id ] ?? [] as $row )
            {
                # найти # owner # admin # edit # view
                if ( !author::$id  &&  in_array($row['role'], ['owner','admin','edit'])  &&  ($user = self::checkEmail($row['email'])) )
                {
                    author::$id     =   $user['id'];
                    author::$email  =   $user['email'];
                    author::$role   =   $row['role'];
                }
                
                
                # публичный обзор
                if ( $row['role'] == 'view'  && $row['email'] == 'public' )
                {
                    $public         =   1;
                    author::$role   =   author::$role ?? 'link';
                }
            }


            # публичный доступ транслировать на все вложения
            #
            unset(pack::$list[ $id ]['public']);
            #
            if ( isset($public) )
            {
                pack::$list[ $id ]['public']  =  $public;
            }
        }


        # обзор по ссылке
        if ( access::checkLink() )
        {
            pack::$list[ $id ]['public']    =  1;
            pack::$list[ $id ]['link']      =  1;
            author::$role   =   author::$role ?? 'link';
        }



        # определить доступные пункты меню
        # право => какие роли имеют доступ
        #
        $menu =   array(
            'link'      =>  ['link', 'view', 'edit', 'admin', 'owner'],
            'view'      =>  ['view', 'edit', 'admin', 'owner'],
            'line'      =>  ['edit', 'admin', 'owner'],
            'tree'      =>  ['edit', 'admin', 'owner'],
            'access'    =>  ['admin', 'owner'],
            'log'       =>  ['admin', 'owner'],
        );
        #
        #
        foreach($menu as $k => $v)
        {
            if ( !in_array(author::$role, $v) )     continue;

            self::$menu[ $k ] = $k;
        }

    }

    
    private static function checkEmail($email)
    {
        if ( empty(author::$list) )     return false;

        foreach(author::$list as $user)
        {
            if ( $user['email'] == $email || strstr($user['email'], $email) !== false )
            {
                return $user;
            }
        }

        return false;
    }


    static function denied($poin)
    {
        $poin   =   is_string($poin) ? [$poin] :  $poin;
        

        if ( !array_intersect($poin, pack::$menu) )
        {
            res::$ret['lineHtml']   =   '<h6 class="denied">403: нет доступа...</h6>';
            res::$ret['href']       =   '/' .pack::$start;
            
            
            return true;
        }

        return false;
    }




}