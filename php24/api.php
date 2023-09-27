<?php
# настройки
#
error_reporting(E_ALL | E_NOTICE);
ini_set('display_errors','On');
session_start();


# авто подключение классов
#
spl_autoload_register( function($name) {
    if ( is_file($file = "../lib/$name.php") )      require_once $file;
});



# запрос
#
url::parse( $_SERVER['REQUEST_URI'], true );
#
req::fromUrl();
req::fromApi();
#
db::init();




# операции по параметрам
#
// user::getCode();
// user::checkCode();

# пачка операции
#
pack::init();
// project::add();
// project::remove();
// line::save();
// tree::save();
// access::save();



# подготовка данных ответа
#
res::userList();
#
res::packStart();
res::packBc();
res::packTree();
res::packHeap();
res::packMenu();
res::packTitle();
res::packProject();
res::lineHtml();
res::lineText();
res::treeText();
res::accessHtml();
res::accessText();
res::wait();




# ответ
#
res::json();
res::html();
