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
    if ( is_file($file = "../state/$name.php") )    require_once $file;
    if ( is_file($file = "../lib/$name.php") )      require_once $file;
});



#  ПРИЛОЖЕНИЕ
#
# бандл для svelte23
#
api::svelte23();


# 1 состояние
#
url::parse($_SERVER['REQUEST_URI'], true);
state::main();
state::pack();


# 2 отдать api json
#
// api::project();
api::end();


# 3 отдать ui серверный варик
#
ui::include('../ui/default.ui.php');

