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

        $list   =   db::select("
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
        

        return  $list;
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
        $subject    =   'Код входа';
        #
        # сохранить в куке
        #
        cookie::set('code', md5($email.$code.$code));


        # отправить письмо
        #
        $smtp       =   new smtp();
        $result     =   $smtp->send($email, $subject, "Цифровой код: $code");
        
        

        # ответ
        #
        res::$ret['ok'] =   'ok';
    }




    # проверить код вохода
    #
    static function checkCode()
    {
        if ( ! rtoken::check() )                return;
        if ( ! url::start('/api') )             return;
        if ( empty($_POST['userCheckCode']) )   return;
        if ( empty($_COOKIE['code']) )          return;
        if ( empty($_POST['code']) )            return;
        
        
        # проверить код
        #
        $email  =   $_POST['userCheckCode'];
        $code   =   $_POST['code'];
        #
        #
        if ( $_COOKIE['code'] != md5($email. $code. $code) )
        {
            res::$ret["check"]  =   "Неверный код...";
            return;
        }



        # поставить токен пользователя в куку
        #
        $token      =   md5( session_id(). time() );
        #
        db::query("
            INSERT INTO `token` (
                  `email`
                , `token`
                , `user_agent`
            )
            VALUES (
                  " .db::v($email). "
                , " .db::v($token). "
                , " .db::v($_SERVER['HTTP_USER_AGENT'] ?? ''). "
            )
        ");
        #
        #
        cookie::del('code');
        cookie::set('token[' .$email. ']', $token, (time()*3600*24*30));

        

        # добавить пользователя / получить стартовый проект
        #
        $user   =   self::dbCreate($email);
        
        

        # json переменные
        #
        res::$ret["href"]  =   "ok";
        // ui::$json["redir"]  =   "/". $user['start'];
    }

        
        # зарегистрировать нового пользователя
        #
        static function dbCreate($email)
        {
            

            # добавить пользователя, если его не существует
            #
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



            # добавить корневую пачку, если её не нет
            #
            db::query("
                INSERT INTO `pack` (
                    `parent`
                    , `name`
                    , `is_project`
                    , `user`
                )

                SELECT
                    0
                    , `user`.`email`
                    , 1
                    , `user`.`id`
                FROM
                    `user`
                        LEFT JOIN `pack`
                        ON  `user`.`id`     =   `pack`.`user`
                        AND `pack`.`parent` =   0
                WHERE
                        `user`.`email` =  " .db::v($email). "
                    AND `pack`.`id` IS NULL
                LIMIT
                    1
            ");

            
            # обновить корневую пачку
            #
            db::query("
                UPDATE
                    `user`
                SET
                    `start` =  (SELECT `id`  FROM `pack`  WHERE `user` = `user`.`id` AND `parent` = 0  LIMIT 1)
                WHERE
                    `email` =  " .db::v($email). "
            ");
            
            

            # получить и вернуть пользователя
            #
            $user   =   db::one("SELECT *  FROM `user`  WHERE `email` =  " .db::v($email) );
            

            return  $user;
        }


}