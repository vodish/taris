<?php
class api
{
    static $pwa =  false;

    
    # отдать заготовку фронтенда
    #
    static function svelte23()
    {
        # проверить под каким хостом запрашивается сайт
        #
        if ( in_array($_SERVER['HTTP_HOST'], ['k.tariz']) )     return;

        # api запрос
        # 
        if ( isset($_SERVER['HTTP_API_KEY']) ) {
            self::$pwa = true;
            return;
        }
        
        # отдать бандл svelte
        #
        die( file_get_contents("index.html") );
    }

    

    

    # закончить исполнение
    #
    static function end()
    {
        if ( api::$pwa == false )    return;
        die;
    }


    static function project()
    {

    }

}