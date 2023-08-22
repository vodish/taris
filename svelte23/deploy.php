<?php
# команда для деплоя из папки svelte23
# C:\OpenServer\modules\php\PHP_8.0\php.exe deploy.php

# сканировать все файлы
#
function sd($dir, $list=[])
{
    $sd =   scandir($dir);

    foreach ( $sd as $file )
    {
        if ( in_array($file, ['.', '..']) ) continue;
        if ( "$dir/$file" == "../../svelte23/dist/index.html" ) continue;

        if ( is_dir( ($next = "$dir/$file") ) )     $list   =   sd($next, $list);
        
        $list[] =   $next;
    }

    return $list;
}


# переложить все фалы и папки
#
$todir  =   "../php23/www";
$dist   =   "dist";
$files  =   sd($dist);

print_r($files);

foreach($files as $f)
{
    // $mkdir  =   str_replace($dir, "", $f);
    // if ( !is_dir($fi) )
    // mkdir(dirname($file))
    // copy($f, str_replace($dir, "", $f));
}
