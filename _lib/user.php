<?php
class user
{
    # получить список профилей
    #
    static function dbUserList()
    {
        if ( !is_array(@$_COOKIE['token']) )     return array();

        foreach($_COOKIE['token'] as $email => $token)
        {
            $where[] = "(`token`.`email` = " .db::v($email). " AND `token`.`token` = " .db::v($token). " AND `token`.`is_active` = 1)";
        }

        $list   =   db::select("
            SELECT
                 `user`.`email`
                ,`user`.`start`
            FROM
                `user`
                    JOIN `token`    ON `user`.`email` = `token`.`email`
            WHERE
                 " .implode("\n\tOR\t ", $where). "
        ");

        return $list;
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
    private static function dbCreate($email)
    {
        return [
            'email' => 'vodish@yandex.ru',
            'start' => 1,
        ];


        # получить корневой проект
        #
        $pack = db::select("-
            SELECT
                *
            FROM
                `pack`
            WHERE
                    `name`      =   " .db::v($email). "
                AND `parent`    =   0
                AND `iproject`  =   
        ");
    }


}