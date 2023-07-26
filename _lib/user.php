<?php
class user
{

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
            die('{"err":"Неверный код... ' .time(). '"}');
        }



        # поставить токен пользователя в куку
        #
        $token  =   md5( session_id(). $_COOKIE['code'] );
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
        load::setcookie('token', $token);

        


        die('{"redir": "/1"}');
    }





}