<?php
class user
{
    static $list = array();


    # получить список профилей
    #
    static function dbList()
    {
        if ( !is_array(@$_COOKIE['token']) )     return array();

        foreach($_COOKIE['token'] as $email => $token)
        {
            $where[] = "(`token`.`email` = " .db::v($email). " AND `token`.`token` = " .db::v($token). " AND `token`.`is_active` = 1)";
        }

        db::query("
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

        while( $v = db::fetch() )
        {
            self::$list[ $v['email'] ]  =  $v;
        }


        return  self::$list;
    }





    # отправить код вохода
    #
    static function actionCodeSend()
    {
        if ( empty($_POST['actionCodeSend']) )  return;
        if ( empty($_POST['ft']) )              return;
        if ( empty($_POST['email']) )           return;
        #
        if ( !isset( $_SESSION['ft'][ $_POST['ft'] ] ) )      die('{"send":"ok1"}');
        

        # код входа
        #
        $email      =   $_POST['email'];
        $code       =   rand(1000, 9999);
        $subject    =   rawurlencode('Код входа: ' .$code );
        #
        # сохранить в куке
        #
        load::setcookie('code', md5($email.$code.$code));


        # отправить письмо
        #
        // $smtp       =   new smtp();
        // $result     =   $smtp->send($email, $subject, 'Смотрите в тему письма.');
        
        
        die('{"send":"ok", "code":' .$code. '}');
    }


    # проверить код вохода
    #
    static function actionCodeCheck()
    {
        if ( empty($_POST['actionCodeCheck']) ) return;
        if ( empty($_POST['ft']) )              return;
        if ( empty($_POST['email']) )           return;
        if ( empty($_POST['code']) )            return;
        if ( empty($_COOKIE['code']) )          return;
        #
        if ( !isset( $_SESSION['ft'][ $_POST['ft'] ] ) )      die('{"check":"ok1"}');
        


        # проверить код
        #
        if ( $_COOKIE['code'] != md5($_POST['email'].$_POST['code'].$_POST['code']) )
        {
            die('{"check":"Неверный код..."}');
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
                  " .db::v($_POST['email']). "
                , " .db::v($token). "
                , " .db::v($_SERVER['HTTP_USER_AGENT'] ?? ''). "
            )
        ");
        #
        #
        load::delcookie('code');
        load::setcookie('token[' .$_POST['email']. ']', $token, (time()*3600*24*30));

        

        # добавить пользователя / получить стартовый проект
        #
        $user   =   self::dbCreate($_POST['email']);
        

        die('{"check": "OK", "redir": "/' .$user['start']. '"}');
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