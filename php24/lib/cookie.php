<?php
class cookie
{
    static function set($name, $value, $lifetime=false)
    {
        setcookie($name, '', time()-1);
        setcookie($name, '', time()-1, '/', url::host());
        
        $year       =   2 + date('Y');
        $lifetime   =   $lifetime ?  time()+$lifetime :  mktime(1, 1, 1, 1, 1, $year);
        
        $t  =   setcookie($name, $value, mktime(1, 1, 1, 1, 1, $year));
        
        return $t;
    }

    static function del($name)
    {
        setcookie($name, '', (time()-1));
        setcookie($name, '', (time()-1), '/', url::host());
    }

}