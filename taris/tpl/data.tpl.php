<?php
header('Content-Type: text/json');


# подключение к бд
#
db::init();


# автоподключение классов из папки data
#
spl_autoload_register(function($name){  if ( is_file($file = __DIR__. '/data/'. $name. '.php') )    require_once $file;   });




# когда не сработали верхние обработчики
#
$arr = array(
  'url'   =>  $_SERVER['REQUEST_URI'],
  'post'  =>  $_POST,
);
data::returnd($arr);

