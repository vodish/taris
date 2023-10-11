<?php
class log
{
    static $list;

    static function dbList()
    {
        if ( ! user::$id )                          return;
        if ( ! in_array('logList', req::$wait) )    return;


        self::$list =   db::select("
            SELECT
                 `created`
                ,`author`
                ,`author_email`
                ,`target`
                ,`row`
            FROM
                `log`
            WHERE
                `user` = " .db::v(user::$id). "
            ORDER BY
                `created` DESC
            LIMIT
                20
        ");


        return  self::$list;
    }



}