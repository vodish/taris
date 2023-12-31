<?php
class log
{
    static $list;

    static function dbList()
    {
        if ( ! user::$id )                          return;
        if ( ! in_array('logList', req::$wait) )    return;


        self::$list = db::select("
            SELECT  *
            FROM    `log`
            WHERE   `user` = " .db::v(user::$id). "
            ORDER BY `created` DESC
            LIMIT   20
        ");
        

        return  self::$list;
    }


    # восстановить из лога
    #
    static function up()
    {
        if ( ! user::$id )                  return;
        if ( @url::$level[1] != 'logUp' )   return;
        if ( pack::denied('log') )          return;


        $log    =   db::one("
            SELECT  *
            FROM    `log`
            WHERE   `user` = '" .user::$id. "'  AND `id` = '" .url::$level[2]. "'
        ");
        #
        if ( empty($log) )      return;

        
        if ( $log['target'] == 'tree' )
        {
            tree::log();
            pack::$tree =   json_decode($log['json'], true);
            tree::dbSave();
        }
        

        res::$ret['href']   =   url::$dir[0];
    }
}