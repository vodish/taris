<?php
# specific vars for siteYYYY
#
// db::init();


# type first template for load::$layout
#
$layout  =  'main.tpl.php';

if      ( url::$path=='/index.php')     url::redir('/');
elseif  ( url::$path=='/')              $layout =  'main.tpl.php';
elseif  ( url::start('/data')   )       $layout =  'data.tpl.php';


return  $layout;