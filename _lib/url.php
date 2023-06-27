<?php
class url
{
    static $path;
    static $query;
    static $dir;
    static $level;
    
    
    static function parse( $url,  $static=false )
    {
        $parse  =   parse_url($url);
        $parse['query'  ]   =   $query  =  $parse['query'] ?? null;
        $parse['dir'    ]   =   array();
        $parse['level'  ]   =   $parse['path']=='/'?  array():  explode('/', trim($parse['path'], '/'));
        
        # query params
        parse_str($query ?? '', $parse['query']);
        
        # dir path
        $dir    =   '';
        foreach ($parse['level'] as $k => $v)  $parse['dir'][$k]  =  $dir .= '/' .$v;
        

        # set static value
        if ( $static )
        {
            self::$path     =   $parse['path'];
            self::$query    =   $parse['query'];
            self::$dir      =   $parse['dir'];
            self::$level    =   $parse['level'];
        }

        return $parse;
    }

    
    static function start( $str )
    {
        $strlen =   strlen($str);
        $start  =   substr(self::$path, 0, $strlen);
        
        return  $str == $start;
    }
    
    
    static function fset( $arr=array(),  $get=array() )
    {
        $get   =   self::$query;
        
        foreach ($arr as $k=>$v)
        {
            if ( $v === null )
            {
                unset($get[$k]);
                unset($arr[$k]);
            }
        }
        
        $get   =   array_merge($get, $arr);
        $get   =   $arr === null ?  array():  $get;
        
        
        return  ($get? '?': ''). http_build_query($get);
    }
    

    static function redir($url, $code='')
	{
	    if ( $code==301 )      header('HTTP/1.1 301 Moved Permanently');
	    
		header('Location: '. $url);
		die;
	}

	static function protocol()
	{
	    return 'http'. (!empty($_SERVER['HTTPS']) && 'off' !== strtolower($_SERVER['HTTPS'])?  's'  :  ''). '://';
	}
	
	static function host()
	{
	    return  preg_replace('#:\d+$#', '', $_SERVER['HTTP_HOST']);
	}
	
	static function site()
	{
	    return  self::protocol(). self::host();
	}
	
	

}