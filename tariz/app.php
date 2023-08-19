<?php
# отображение ошибок
#
error_reporting(E_ALL | E_NOTICE);
ini_set('display_errors','On');
#
#
# авто подключение классов
#
spl_autoload_register( function($name) {
    if ( is_file($file = "../src/$name.php") )     require_once $file;
    if ( is_file($file = "../../_lib/$name.php") ) require_once $file;
});
#
#
# использование сессии
#
session_start();


##########################################################################
# приложение
#
# 1 # установить состояние
#
url::parse($_SERVER['REQUEST_URI'], true);
state::main();
state::pack();


# 2 # загрузить ui
#
load::ui('../ui/default.ui.php');
