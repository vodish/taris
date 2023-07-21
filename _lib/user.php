<?php
class user
{
    static function actionLoginSend()
    {
        if ( empty($_POST['email']) )   return ;

        //load::vdd('отправить письмо');
        load::vd($_POST);

        $message = '
        <h3>Заголовок</h3>
        <p>Параграф</p>
        <p>Параграф</p>
        ';

        $smtp = new smtp();
        // $result =  $smtp->send($_POST['email'], 'Тема письма' .time(), $message );
        // load::vd($result, 1);
        
        load::vd($_SESSION);

        url::redir('/1');
    }
}