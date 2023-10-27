<?php
# константы
#
require_once __DIR__. "/lib/_config.php";
#
#
# ошибки
#
error_reporting(E_ALL | E_NOTICE);
ini_set('display_errors', 'On');
#
#
# сессия
#
session_start();
#
#
# авто подключение классов
#
spl_autoload_register( function($name) {
    if ( is_file($file = __DIR__. "/lib/$name.php") )      require_once $file;
});



# запрос
#
url::parse();
req::fromUrl();
req::fromApi();
db::init();



# операции по параметрам
#
user::getCode();
user::checkCode();
user::bye();
#
# операции пачек
#
pack::dbInit();
line::upd();
tree::upd();
tree::add();
tree::del();
access::upd();
access::link();
log::up();




# cостояние
#
state::userList();
#
state::packStart();
state::packMenu();
state::packBc();
state::packTree();
state::packTitle();
#
state::isProject();
state::treeText();
state::lineHtml();
state::lineText();
#
state::accessText();
state::logList();


# логирование sql запросов
// db::log('../log/_sql_.log');

# ответ
#
res::json();
res::html();


