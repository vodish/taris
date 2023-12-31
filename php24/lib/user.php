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
        $smtp       =   new smtp();
        $result     =   $smtp->send($email, "Код входа", "Цифровой код: $code");
        #
        cookie::set('code', md5($email.$code.$code));

        
        # ответ
        #
        res::$ret['ok']     =   'ok';
        // res::$ret['code']   =   PATH_SEPARATOR == ';' ?  $code : '';
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


        # добавить/получить пользователя
        #
        $user   =   self::dbCreate($email, $token);
        #
        cookie::del('code');
        cookie::set('token[' .$email. ']',  $token,  time()*3600*24*30);
        $_COOKIE['token'][ $email ] =   $token;
        


        # вернуть данные
        #
        res::$ret['userList']   =   author::dbInit();
        #
        req::$param['pack']     =   $user['start'];
        req::$wait              =   array_merge(req::$wait, ['packStart', 'packProject', 'packBc', 'packTree', 'packMenu', 'packTitle', 'lineHtml']);
        

        
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
        $user       =   db::one("SELECT *  FROM `user`  WHERE `email` = " .db::v($email)  );
        

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
            #
            $ulen           =   strlen( (string) $user['id'] );
            $ulen           =   strtr( (string) $ulen, ['10'=>'A', '11'=>'B', '12'=>'C', '13'=>'D']);
            $user['start']  =   intval( $ulen. $user['id']. '0' );
            #
            #
            # добавить корневую пачку
            #
            db::query("
                UPDATE  `user`
                SET     `start` =   " .db::v($user['start']). "
                WHERE   `id`    =   " .db::v($user['id'])
            );
            #
            db::query("
                INSERT INTO `pack` (
                      `user`
                    , `id`
                    , `name`
                )
                VALUES (
                      " .db::v($user['id']). "
                    , " .db::v($user['start']). "
                    , " .db::v($email). "
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
        if ( empty(url::$level) )           return;
        if ( @url::$level[0] != 'bye' )     return;
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