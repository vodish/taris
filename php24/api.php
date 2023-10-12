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
url::parse();
req::fromUrl();
req::fromApi();
db::init();



# операции по параметрам
#
// user::getCode();
// user::checkCode();

# пачка операции
#
pack::dbInit();
line::save();
tree::upd();
tree::add();
tree::del();
// access::save();
log::up();


# cостояние
#
state::userList();
#
state::packStart();
state::packProject();
state::packBc();
state::packTree();
state::packMenu();
state::packTitle();
#
state::treeText();
state::lineHtml();
state::lineText();
#
state::accessHtml();
state::accessText();
#
state::logList();

// ui::vd(res::$ret);

# ответ
#
res::json();
res::html();
