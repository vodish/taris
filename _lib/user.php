<?php
class user
{
    static function actionLoginSend()
    {
        if ( empty($_POST['email']) )   return ;

        load::vdd('отправить письмо');

        load::vdd($_POST);
        load::vdd($_SESSION);
    }
}