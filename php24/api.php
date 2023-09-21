<?php
# отображение ошибок
#
error_reporting(E_ALL | E_NOTICE);
ini_set('display_errors','On');
#
# сессия
#
session_start();
#
# авто подключение классов
#
spl_autoload_register( function($name) {
    if ( is_file($file = "../lib/$name.php") )      require_once $file;
});



# входящий запрос
# определить операции на выполнение и переменные на отдачу
#
url::parse( $_SERVER['REQUEST_URI'], true );
#
req::forMain();
req::forPack();
req::check();



# окружение
#
db::init();


# главная операции
#
// user::getCode();
// user::checkCode();
// user::list();


/*
# пачка операции
#
pack::init();
project::add();
project::remove();
line::save();
tree::save();
access::save();

*/


# 2 отдать данные
#
ans::json();
ans::html();
