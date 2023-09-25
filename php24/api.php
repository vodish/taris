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



# окружение
# входящий запрос
#
url::parse( $_SERVER['REQUEST_URI'], true );
#
req::fromUrl();
req::fromApi();
#
db::init();



/*
# операции
#
// user::getCode();
// user::checkCode();

# пачка операции
#
pack::init();
project::add();
project::remove();
line::save();
tree::save();
access::save();
*/


# результат
#
res::json();
res::html();
