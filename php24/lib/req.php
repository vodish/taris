<?php
class req
{

    static function toMain()
    {
        if ( url::$path != '/' )    return;

        $_POST['wait']  =   ['userLst'];

    }

    static function toPack()
    {
        if ( ! url::$level[0] )                 return;
        if ( ! is_numeric(url::$level[0]) )     return;

        
        $_POST['pack']  =   url::$level[0];
        $_POST['wait']  =   ['pack'];

        if      ( !isset(url::$level[1]) )      $_POST['wait']  =   ['lineHtml'];
        elseif  ( url::$level[1] == 'line' )    $_POST['wait']  =   ['lineText'];
        elseif  ( url::$level[1] == 'tree' )    $_POST['wait']  =   ['treeText'];
        elseif  ( url::$level[1] == 'access' )  $_POST['wait']  =   ['accessArray', 'accessText'];
    }


    static function init()
    {
        # привести запрос к единому формату
        #
        if ( url::$level[0] )


    }



}