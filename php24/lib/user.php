<?php
class user
{
    # хозяин пачки
    #
    static $id;
    static $email;
    static $start;


    # счетчик идишников пльзователя
    #
    static $prefix;
    static $counter;
    static function nextid()    { return  intval(self::$prefix .  ++self::$counter); }




    # получить список профилей
    #
    static function list()
    {
        if ( empty($_COOKIE['token']) )        return [];
        

        # список пользователей из базы
        #
        foreach($_COOKIE['token'] as $email => $token)
        {
            $where[] = "(`token`.`email` = " .db::v($email). " AND `token`.`token` = " .db::v($token). " AND `token`.`is_active` = 1)";
        }
        #
        #
        $userList  =  db::select("
            SELECT
                 `user`.`id`
                ,`user`.`email`
                ,`user`.`start`
            FROM
                `user`
                    JOIN `token`    ON `user`.`email` = `token`.`email`
            WHERE
                " .implode("\n\tOR\t ", $where). "
            ORDER BY
                `user`.`id`
        ");
        

        return  $userList;
    }





    # отправить код вохода
    #
    static function getCode()
    {
        if ( ! rtoken::check() )                    return;
        if ( ! url::start('/api') )                 return;
        if ( empty(req::$param['userGetCode']) )    return;
        

        # код входа
        #
        $email      =   $_POST['userGetCode'];
        $code       =   rand(1000, 9999);
        

        # отправить письмо
        # сохранить в куке
        #
        // $smtp       =   new smtp();
        // $result     =   $smtp->send($email, "Код входа", "Цифровой код: $code");
        #
        cookie::set('code', md5($email.$code.$code));

        
        # ответ
        #
        res::$ret['ok'] =   'ok';
        res::$ret['code'] =   $code;
    }




    # проверить код вохода
    #
    static function checkCode()
    {
        if ( ! rtoken::check() )                    return;
        if ( ! url::start('/api') )                 return;
        if ( empty($_POST['userCheckCode']) )       return;
        if ( empty($_COOKIE['code']) )              return;
        if ( empty($_POST['code']) )                return;
        
        
        # проверить код
        #
        $email  =   $_POST['userCheckCode'];
        $code   =   $_POST['code'];
        $token  =   md5( session_id(). time() );
        #
        #
        if ( $_COOKIE['code'] != md5($email. $code. $code) )
        {
            res::$ret["err"] =  "Неверный код...";
            return;
        }


        # добавить пользователя
        #
        $user   =   self::dbCreate($email, $token);
        #
        cookie::del('code');
        cookie::set('token[' .$email. ']',  $token,  time()*3600*24*30);
        $_COOKIE['token'][ $email ]   =   $token;
        

        # обновить userList


        
        # ответ
        #
        res::$ret["href"]  =   '/'. $user['start'];
    }




    # зарегистрировать нового пользователя
    #
    static function dbCreate($email, $token)
    {

        # проверить авторизацию в куке
        #
        $user   =   db::one("SELECT *  FROM `user`  WHERE `email` = " .db::v($email)  );
        

        # добавить пользователя
        #
        if ( empty($user) )
        {
            db::query("
                INSERT INTO `user` (
                    `email`
                )
                
                SELECT
                    `new`.`email`
                FROM
                    (SELECT " .db::v($email). " AS `email`) AS `new`
                        LEFT JOIN `user`
                        ON `new`.`email`    =   `user`.`email`
                WHERE
                    `user`.`email` IS  NULL
            ");
            #
            $user['id']     =   db::lastId();
            $user['email']  =   $email;
            $user['start']  =   intval( strval($user['id']).'0' );
            #
            #
            # добавить корневую пачку
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

                VALUES (
                    " .db::v($user['id']). "
                    ," .db::v($user['start']). "
                    ,0
                    ,0
                    ," .db::v($email). "
                    ,0
                    ,0
                )
            ");
        }
        


        # добавить токен пользователя
        #
        db::query("
            INSERT INTO `token` (
                  `user`
                , `email`
                , `token`
                , `user_agent`
            )
            VALUES (
                  " .db::v( $user['id'] ). "
                , " .db::v( $email ). "
                , " .db::v( $token ). "
                , " .db::v( $_SERVER['HTTP_USER_AGENT'] ?? '' ). "
            )
        ");
        
        
        
        # вернуть пользователя
        #
        return  $user;
    }



    # выход из профиля
    #
    static function bye()
    {
        if ( url::$level[0] != 'bye' )      return;
        if ( empty(url::$level[1]) )        return;
        if ( empty($_COOKIE['token']) )     return;
        if ( !isset($_COOKIE['token'][ url::$level[1] ]) )    return;

        
        # удалить куку
        # пречитать профили
        # переадресация на страницу
        #
        cookie::del("token[" .url::$level[1]. "]");
        unset($_COOKIE['token'][url::$level[1]]);
        #
        #
        req::$wait[]        =  "userList";
        #
        #
        res::$ret['href']   =   "/";

    }


}