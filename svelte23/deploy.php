<?php
# команда для деплоя из папки svelte23
# C:/OpenServer/modules/php/PHP_8.0/php.exe deploy.php

if ( !is_dir($dir = '../php24/www/assets') )    die;

foreach(scandir($dir) as $file)
{
    if (in_array($file, ['.', '..']))  continue;

    unlink("$dir/$file");
}
