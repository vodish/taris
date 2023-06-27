<?php
class load
{
    static	$dirtpl;
    static	$layout;
	static	$tpl;
	static	$body;
	
    static	$title;
    

    static function renderpage()
    {
		do {
            self::$tpl      =   self::$layout;
            ob_start();
            require_once        self::$dirtpl. '/' .self::$layout;
            self::$body     =   ob_get_clean();
        }
        while (self::$tpl != self::$layout);
        
        die( self::$body );
    }
    
    
	
	static function makefile($file, $tpl, $addtime=true, $php=true)
	{
	    chdir($_SERVER['DOCUMENT_ROOT']);
	    
	    $dirlib    =   dirname(__FILE__);
	    $file      =   trim($file, '/');
	    $dir       =   dirname($file);
	    $md5file   =   file_exists($file)?  md5_file($file):  '';
	    
	    
	    $tplfile   =   trim($tpl, '/');
	    if ( file_exists(self::$dirtpl. '/' .$tplfile) )   $tplfile =  self::$dirtpl. '/' .$tplfile;
	    if ( file_exists(      $dirlib. '/' .$tplfile) )   $tplfile =        $dirlib. '/' .$tplfile;
	    
	    
	    if ( !file_exists($dir) )
	    {
	        umask(0);
	        mkdir($dir, 0777, true);
	    }
	    
	    
	    if ( !$php || in_array(substr($tplfile, -3, 3), array('png','gif','jpg','peg')) )
	    {
	        $md5tpl    =   md5_file($tplfile);
	        
	        if ( $md5file != $md5tpl )   copy($tplfile, $file);
	    }
	    elseif ( !file_exists($tplfile) )
	    {
	        $md5tpl    =   md5($tpl);
	        
	        if ( $md5tpl != $md5file ) file_put_contents($file, $tpl, LOCK_EX);
	    }
	    else
	    {
	        ob_start();
    	    require_once $tplfile;
    	    $content   =   ob_get_clean();
    	    $md5tpl    =   md5( $content );
    	    
    	    if ( $md5tpl != $md5file )     file_put_contents($file, $content, LOCK_EX);
	    }
	    
	    
	    return  '/'.$file. ($addtime? '?'.$md5tpl: '');
	}
	

	static function vd($var=null, $print_r=true)
	{
	    $backtrace	=	debug_backtrace();
        
        echo '<pre style="max-width: 90%; overflow: auto;">';
        
        echo $backtrace[0]['file']. ': ' .$backtrace[0]['line']. "\n";

        $print_r ?  print_r($var) :  var_dump($var);
        
        echo '</pre>';
	    
	}
	
	static function vdd($var=null, $print_r=true)
	{
	    $backtrace	=	debug_backtrace();
	    
        echo '<pre style="max-width: 90%; overflow: auto;">';
        
        echo $backtrace[0]['file']. ': ' .$backtrace[0]['line']. "\n";
		
        $print_r ?  print_r($var) :  var_dump($var);
        
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