<?php
class ui
{
    
    static function vd($var=null, $print_r=null, $step=false)
    {
        $trace	=	debug_backtrace();
        if ( $trace[0]['file'] == __FILE__ && $trace[0]['function'] == 'vd' )    array_shift($trace);
        $trace	=	array_reverse($trace);

        
        echo '<pre style="max-width: 90%; overflow: auto;">';
        foreach($trace as $v)
        {
            echo  $v['file']. '::' .$v['line']. "\n";
            if ( $step==false )   break;
        }

        $print_r === null ?  print_r($var) :  var_dump($var);
        
        echo '</pre>'. "\n";

    }

    static function vdd($var=null, $print_r=null, $step=false)
    {
        self::vd($var, $print_r, $step);
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