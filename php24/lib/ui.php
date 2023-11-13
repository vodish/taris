<?php
class ui
{
    
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



    static function typograf($str)
    {
        return preg_replace("#\s+(\S{1,2})\s+(\S{3})#u", " $1&nbsp;$2", $str);
    }

    static function typograf1($text)
    {
        if ( empty($text) )
        {
            return $text;
        }
        
        if ( strpos($text, '<') === false )
        {
            return self::typograf($text);
        }
        
        
        $text   =   preg_replace_callback('#(<[^>]+>) (\s*[^<]+)#x', function($m){
            
            return  $m[1]. self::typograf( $m[2]);
            
        }, $text);
        
        return $text;
    }
    
}