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



# состояние: создать данные
#
url::parse($_SERVER['REQUEST_URI'], true);
request::init();
db::init();
//

# главная страница
#
user::getCode();
user::checkCode();
// user::list();


/*
# операции с пачкой
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
