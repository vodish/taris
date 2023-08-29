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



# ПРИЛОЖЕНИЕ
#
# 1 создать данные (состояние)
#
url::parse($_SERVER['REQUEST_URI'], true);
rtoken::init();
state::main();
state::pack();


# 2 отдать данные (в обертке)
#
ui::include('../ui/svelte.bundle.php');
ui::include('../ui/rtoken.api.php');
ui::include('../ui/default.ui.php');

