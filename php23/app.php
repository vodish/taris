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
# состояние: создать данные
#
url::parse($_SERVER['REQUEST_URI'], true);
db::init();
#
#
# главная страница
#
user::getCode();
user::checkCode();
user::list();
#
#
# проект
#
pack::init();

state::pack();



# 2 отдать данные
#
// отдать бандл если пришел запрос без rtoken
ui::jsonDie();
ui::bundleSvelteDie();
ui::include('../ui/svelte.bundle.php');
ui::include('../ui/default.ui.php');
