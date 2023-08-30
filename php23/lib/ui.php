<?php
class ui
{
    static $title;
    static $html    =   array();
    static $json    =   array();
    

    # зарегистрировать шаблон html
    #
    static function html($file)
    {
        self::$html[]	=	ltrim($file, '/');
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

        if ( !in_array($file, ui::$html) )    return ;

        
        include $file;
    }





    # отдать бандл
    #
    static function bundleSvelteDie()
    {
        
    }



    # отдать по api json
    #
    static function jsonDie()
    {
        if ( empty($_POST['rtoken']) )  return;
        if ( empty(self::$json) )       return;


        ui::$json['rtoken']   =   rtoken::init();

        header('Content-Type: application/json; charset=utf-8');
        echo  json_encode(self::$json);
        die;
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
        echo '</pre>'. "\n";

    }

    static function vdd($var=null, $print_r=null, $trace=1)
    {
        self::vd($var, $print_r, $trace);
        die;
    }

    
}