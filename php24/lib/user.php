<?php
class user
{
    static $list    =   array();


    # получить список профилей
    #
    static function list()
    {
        // if ( !empty($_POST['action']) )

        # условие выполнения функции
        #
        if ( is_array(@$_COOKIE['token']) )
        {
            if ( url::$path == "/" )    $exec = true;
            if ( url::start("/api")  && rtoken::check()  && isset($_POST['userList']) )    $exec = true;
        }
        elseif ( url::start("/api")  && rtoken::check()  && isset($_POST['userList']) )
        {
            return  ui::$json['userList'] = array();
        }
        #
        if ( !isset($exec) )    return user::$list;
        

        

        # список пользователей из базы
        #
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
            user::$list[]  =  $v;
        }



        # html
        #
        ui::$title =  'Taris.pro';
        ui::html('../ui/default.ui.php');
        ui::html('../ui/main/main.ui.php');


        # json
        #
        ui::$json['userList']   =   user::$list;
        

        return  self::$list;
    }




    # отправить код вохода
    #
    static function getCode()
    {
        if ( ! rtoken::check() )                return;
        if ( ! url::start('/api') )             return;
        if ( empty($_POST['userGetCode']) )     return;
        if ( empty($_POST['email']) )           return;
        
        

        # код входа
        #
        $email      =   $_POST['email'];
        $code       =   rand(1000, 9999);
        $subject    =   rawurlencode('Код входа: ' .$code );
        #
        # сохранить в куке
        #
        cookie::set('code', md5($email.$code.$code));


        # отправить письмо
        #
        // $smtp       =   new smtp();
        // $result     =   $smtp->send($email, $subject, 'Смотрите в тему письма.');
        

        # json переменные
        #
        ui::$json["send"]   =   "ok";
        ui::$json["code"]   =   $code;
    }




    # проверить код вохода
    #
    static function checkCode()
    {
        if ( ! rtoken::check() )                return;
        if ( ! url::start('/api') )             return;
        if ( empty($_POST['userCheckCode']) )   return;
        if ( empty($_COOKIE['code']) )          return;
        if ( empty($_POST['email']) )           return;
        if ( empty($_POST['code']) )            return;
        
        
        
        # проверить код
        #
        if ( $_COOKIE['code'] != md5($_POST['email']. $_POST['code']. $_POST['code']) )
        {
            return rtoken::check(['check'=>"Неверный код..."]);
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
        cookie::del('code');
        cookie::set('token[' .$_POST['email']. ']', $token, (time()*3600*24*30));

        

        # добавить пользователя / получить стартовый проект
        #
        $user   =   self::dbCreate($_POST['email']);
        
        

        # json переменные
        #
        ui::$json["check"]  =   "ok";
        ui::$json["redir"]  =   "/". $user['start'];
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