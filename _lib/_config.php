<?php
error_reporting(E_ALL | E_NOTICE);
ini_set('display_errors','On');


# autoload class from current dir
#
spl_autoload_register( function($name) {
    
    if ( is_dir($dir = __DIR__.'/'.$name)  && is_file($file = "$dir/$name.php") )
    {}
    elseif ( ($e = explode('_', $name))  && !empty($e[1])  && !is_file(__DIR__."/$name.php") )
    {
        $dir    =   array_slice($e, 1);
        $dir    =   implode('/', $dir);
        $file   =   __DIR__. "/$dir/$name.php";
    }
    else
    {
        $file   =   __DIR__. "/$name.php";
    }
    
    if ( is_file($file) )
    {
        require_once $file;
    }
});


# optional global settings
#
session_start();
url::parse($_SERVER['REQUEST_URI'], true);




# set template dirpath for class `load`
# set start layout file_name (and adds project setting)
# render output
#
load::$dirtpl   =   $_SERVER['DOCUMENT_ROOT']. '/../tpl';
#
load::$layout   =   require_once  load::$dirtpl. '/_route.php';
#
load::vd(url::$path);

load::renderpage();

