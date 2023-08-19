<?php
class load
{
    static  $uiList =   array();
    static  $title;
    

    static function setUi($file)
    {
        self::$uiList[]	=	ltrim($file, '/');
    }

    static function ui($file)
    {
        if ( !in_array($file, self::$uiList) )		return;
        
        require	 $file;
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
            $url    .=   $addtime? '?'.md5_file($from): '';
        }   
        else {
            file_put_contents($to, $from);
            $url    .=   $addtime? '?'.md5($from): '';
        }                    


        return $url;
	}
	


	static function vd($var=null, $print_r=null, $trace=true)
	{
	    $backtrace	=	debug_backtrace();
        
        echo '<pre style="max-width: 90%; overflow: auto;">';
        
        echo  $trace ?  $backtrace[0]['file']. '::' .$backtrace[0]['line']. "\n" :  '';

        $print_r === null ?  print_r($var) :  var_dump($var);
        
        echo '</pre>';
	    
	}
	
	static function vdd($var=null, $print_r=null, $trace=true)
	{
	    $backtrace	=	debug_backtrace();
	    
        echo '<pre style="max-width: 90%; overflow: auto;">';
        
        echo  $trace ?  $backtrace[0]['file']. '::' .$backtrace[0]['line']. "\n" :  '';
		
        $print_r === null ?  print_r($var) :  var_dump($var);
        
        echo '</pre>';
	    
	    die;
	}
	
	
	
	
	static function setcookie($name, $value, $lifetime=false)
	{
	    setcookie($name, '', time()-1);
		setcookie($name, '', time()-1, '/', url::host());
		
        $year       =   2 + date('Y');
        $lifetime   =   $lifetime ?  time()+$lifetime :  mktime(1, 1, 1, 1, 1, $year);
        
        $t  =   setcookie($name, $value, mktime(1, 1, 1, 1, 1, $year));
        
        return $t;
	}
	
	static function delcookie($name)
	{
	    setcookie($name, '', (time()-1));
	    setcookie($name, '', (time()-1), '/', url::host());
	}
	
	
	
}