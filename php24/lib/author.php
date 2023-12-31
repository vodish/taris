<?php
class author
{
    static $init    =   false;
    static $list    =   [];

    static $id;
    static $role;
    static $email;
    

    # получить список профилей
    #
    static function dbInit()
    {
        if ( empty($_COOKIE['token']) )     return [];
        if ( self::$init )                  return self::$list;
        
        self::$init =   true;


        # список пользователей из базы
        #
        foreach($_COOKIE['token'] as $email => $token)
        {
            $where[]    =   "(`token`.`email` = " .db::v($email). " AND `token`.`token` = " .db::v($token). " AND `token`.`is_active` = 1)";
            $order[]    =   db::v($token);
        }
        #
        #
        #
        self::$list =   db::select("
            SELECT
                 `user`.`id`
                ,`user`.`email`
                ,`user`.`start`
            FROM
                `user`
                    JOIN `token`    ON `user`.`email` = `token`.`email`
            WHERE
                " .implode("\n\tOR\t ", $where). "
            ORDER BY
                FIELD(`token`.`token`, " .implode(',', $order). ")
        ");
        
        

        return self::$list;
    }

    
    


}