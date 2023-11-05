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

    
}