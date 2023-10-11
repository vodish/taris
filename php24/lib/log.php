<?php
class log
{
    static $list;

    static function dbList()
    {
        if ( ! user::$id )                          return;
        if ( ! in_array('logList', req::$wait) )    return;


        db::query("
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

        for( $list=[];  $v = db::fetch();  $list[] = $v )
        {
            $v['target_name']       =   strtr($v['target'], ['tree'=>'Дерево', 'file'=>'Файл', 'access'=>'Права' ]);
            $v['up_name']     =   "Восстановить";
        }


        return  self::$list =   $list;
    }



}