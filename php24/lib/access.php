<?php
class access
{
    static $list;
    

    static function dbInit()
    {
        if ( empty(user::$id) )     return;
        


        # получить все запии из таблицы прав
        #
        db::query("
            SELECT
                *
            FROM
                `access`
            WHERE
                `user` = " .db::v(user::$id). "
            ORDER BY
                `id`
        ");

        while( $v = db::fetch() )
        {
            self::$list[] =  $v; 
        }

        
    }
    


    # список прав для пачке как html
    #
    static function asHtml($packId)
    {
        $access =   self::$list[ $packId ] ?? array();
        $html   =   '';
        
        if ( !$access )     return '';

        foreach( $access as $email => $v )
        {
            $html   =   '';
            $html   .=  '<pre>' .$email. ':</pre>';
            $html   .=  '<pre>    role: ' .$v['role']. '</pre>';
            $html   .=  $v['comment'] ? '<pre>    comment: ' .$v['comment']. '</pre>': '';
            $html   .=  '<br />';
        }

        return $html;
    }

    # список прав для пачки как текст
    #
    static function asText($packId)
    {
        $access =   self::$list[ $packId ] ?? array();
        $text   =   '';
        
        if ( !$access )     return '';
        
        foreach( $access as $email => $v )
        {
            if ( $v['role'] == 'Owner' )    continue;

            $is_email   =   filter_var($email, FILTER_VALIDATE_EMAIL);
            
            $text   .=  $email. ":\n";
            $text   .=  '    role: '. $v['role']. "\n";
            $text   .=  empty($v['comment']) ?  '' : '    comment: '. $v['comment']. "\n";
            $text   .=  $is_email ?             '' : '    link: '. url::site(). '/'. $packId. '?hash='. $email. "\n";
            $text   .=  $v['updated'] ?         '' : '    updated: '. $v['updated']. "\n";
            $text   .=  "\n";
        }


        return $text;
    }



    # добавить ссылку
    #
    static function actionCreateLink()
    {
        if ( !isset($_GET['createAccessLink']) )     return;

        ui::vdd($_GET);
    }


    # сохранить права
    #
    static function actionSave()
    {
        if ( !isset($_POST['access']) )      return;
        
        self::dbSave($_POST['access']);
        

        url::redir( url::$dir[1],  null, ['save'=>time()] );
    }


        # сохранить в базе
        #
        private static function dbSave($text)
        {
            $proId  =   pack::$project;
            $parse  =   yaml_parse($text);
            $parse  =   is_array($parse) ?  $parse :  array();
            $rows   =   array();

            // ui::vdd($parse);


            # создать временные записи в базе для операций
            #
            foreach( $parse as $email => $v )
            {
                if ( is_numeric($email) )   continue;
                if ( !is_array($v) )        continue;
                if ( !in_array(@$v['role'], ['Admin', 'Edit', 'View']) )    continue;


                $pack       =   db::v($proId). " as `pack`";
                $email      =   db::v($email). " as `email`";
                $role       =   db::v($v['role']). " as `role`";
                $comment    =   db::v($v['comment'] ?? ''). " as `comment`";
                #
                $rows[]     =   " SELECT $pack, $email, $role, $comment". "\n";
            }


            # просто удалить все записи, если несчем сравнивать
            #
            if ( empty($rows) )
            {
                db::query("DELETE FROM `access`  WHERE `pack` = " .db::v($proId) );

                return;
            }



            # создать временную таблицу
            #
            db::query("
                CREATE TEMPORARY TABLE `new`
                " .implode("\n UNION ", $rows). "
            ");

            # добавить новые записи
            #
            db::query("
                INSERT INTO `access` (
                     `pack`
                    ,`email`
                    ,`role`
                    ,`comment`
                )
                SELECT
                     `new`.`pack`
                    ,`new`.`email`
                    ,`new`.`role`
                    ,`new`.`comment`
                FROM
                    `new`
                        LEFT JOIN `access` as `old`
                        ON  `new`.`pack`    =   `old`.`pack`
                        AND `new`.`email`   =   `old`.`email`
                WHERE
                    `old`.`email` IS NULL
            ");
            #
            # изменить записи
            #
            db::query("
                UPDATE
                    `access`
                        JOIN `new`
                        ON  `access`.`pack` = `new`.`pack`
                        AND `access`.`email` = `new`.`email`
                SET
                     `access`.`role`     =   `new`.`role`
                    ,`access`.`comment`  =   `new`.`comment`

                -- todo: кроме владельца
            ");
            #
            # удалить лишние записи
            #
            db::query("
                DELETE
                    `access`.*
                FROM
                    `access`
                        LEFT JOIN `new`
                        ON  `access`.`pack` = `new`.`pack`
                        AND `access`.`email` = `new`.`email`
                WHERE
                    `access`.`pack` = " .db::v($proId). "
                    AND `new`.`email` IS NULL
                    -- todo: кроме владельца
            ");
            
        }


}