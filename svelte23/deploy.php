<?php
# команда для деплоя из папки svelte23
# 
# C:\OpenServer\modules\php\PHP_8.0\php.exe deploy.php


# сканировать папку рекурсивно
#
function sd($dir, $list=[])
{
    $sd =   scandir($dir);

    foreach ( $sd as $file )
    {
        if ( in_array($file, ['.', '..']) ) continue;
        $sub    =   "$dir/$file";
        $list[] =   $sub;
        if ( is_dir($sub) )     $list =  sd($sub, $list);
    }

    return $list;
}


# сканировать сборку в папке dist
#
$todir  =   "../php23/www";
$dist   =   "dist";
$files  =   sd($dist);

# переложить файлы
#
foreach( $files as $from )
{
    $to  =   $todir. substr($from, strlen($dist));

    if ( is_dir($from) )
    {
        if ( !is_dir($to) ) mkdir($to, 0777);
        continue;
    }

    copy($from, $to);
}

