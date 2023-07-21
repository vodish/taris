<?php
class ftoken
{

    # create token
    #
    static function create()
    {
        $token  =   md5( session_id(). time() );
        
        preg_replace_callback('#[3-9]#', function($m) use ($token) {
            
            $value  =   str_split($token, $m[0]);
            $value  =   array_reverse($value);
            $value  =   implode($value);

            $_SESSION['ftoken'][ $value ] =  time();

        }, $token, 1);
        
        
        for($c=count($_SESSION['ftoken']);  $c > 15;  $c--)
        {
            array_shift($_SESSION['ftoken']);
        }


        return $token;
    }


    # 1. print tag input with token value for tag form
    #
    static function input()
    {
        $token  =   self::create();
        
        return  '<input type="hidden" name="t" value="' .$token. '" />' ."\n";
    }

    
    # 2. use js script frontside to decode token
    #
    /*
    $(document).ready(()=>{
        $('form>input[name="t"]').each(function(){ this.value = this.value.match( new RegExp(".{1," + this.value.match(/[3-9]/)[0] + "}", "g") ).reverse().join('') })
    })
    */

}