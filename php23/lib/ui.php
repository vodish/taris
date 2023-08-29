<?php
class ui
{
    static $list;
    static $title;
    static $pwa     =   false;

    static $json    =   array();
    

    # зарегистрировать шаблон html
    #
    static function html($file)
    {
        if ( rtoken::$value )   return;

        self::$list[]	=	ltrim($file, '/');
    }

    # 
    #
    static function jsonApi()
    {
        if ( empty(self::$json) )   return;

        self::$json['rtoken'] = rtoken::init();

        header('Content-Type: application/json; charset=utf-8');
        echo  json_encode(self::$json);
        die;
    }


    # подключить шаблон
    #
    static function include($file)
    {
        if ( !is_file($file))
        {
            self::vd("$file not found", null, 1);
            return;
        }

        if ( !in_array($file, self::$list) )    return ;

        
        include $file;
    }


    static function makefile($to, $from, $addtime=true)
    {
        $url    =   $to;
        $to     =   ltrim($to, "/");
        $from   =   ltrim($from, "/");
        
        # создать папку
        #
        if ( !is_dir( $mkdir = dirname($to) ) )
        {
            umask(0);
            mkdir($mkdir, 0777, true);
        }

        # сокопировать файл в указанное место
        #
        if ( is_file($from) )
        {
            copy($from, $to);
            $url    .=   $addtime?  '?'. md5_file($from) : '';
        }   
        else {
            file_put_contents($to, $from);
            $url    .=   $addtime?  '?'. md5($from) : '';
        }                    

        return $url;
    }
    
    static function vd($var=null, $print_r=null, $trace=0)
    {
        $backtrace	=	debug_backtrace();
        
        echo '<pre style="max-width: 90%; overflow: auto;">';
        echo  $trace!==null ?  $backtrace[$trace]['file']. '::' .$backtrace[$trace]['line']. "\n" :  '';
        $print_r === null ?  print_r($var) :  var_dump($var);
        echo '</pre>';

    }

    static function vdd($var=null, $print_r=null, $trace=1)
    {
        self::vd($var, $print_r, $trace);
        die;
    }

    
}