<?php
class tree
{
    
    # распарсить строчку пачки
    #
    private static function parseline($str)
    {
        preg_match("#^\s*#", $str, $_before);
        preg_match("#\s+\d+$#", $str, $_after);
        #
        $space  =   strlen($_before[0]);
        $id     =   empty($_after[0]) ?  null : (int) trim($_after[0]);
        $name   =   mb_substr($str, mb_strlen($_before[0]), -mb_strlen($_after[0]??0));


        return [
            'user'      =>  null,
            'id'        =>  $id,
            'project'   =>  null,
            'space'     =>  $space,
            'name'      =>  $name,
            'order'     =>  null,
            'file'      =>  null,
        ];
    }


    # дерево в json для лога
    #
    private static function toLog()
    {
        $log    =   array();
        // ui::vd(pack::$tree[112]);
        foreach( pack::$tree as $rows )
        {
            foreach( $rows as $r )  $log[] =  $r;
        }
        
        $log    =   json_encode($log, JSON_UNESCAPED_UNICODE);

        return $log;
    }




    # сохранить дерево с обновленной веткой пачек
    #
    static function save()
    {
        # отладка
        #
        res::treeText();
        req::$param['tree'] =   res::$ret['treeText'];
        


        if ( empty(pack::$start)            )   return;
        if ( !isset(req::$param['tree'])    )   return;
        

        # текущее содержание
        # 
        $oldlog     =   self::toLog();


        # разбить текст по-строчно, каждая пачка на своей строке
        # вспомогательные переменные
        #
        $source     =   req::$param['tree'];
        $source     =   str_replace("\r", '', $source);
        $source     =   trim($source);
        $list       =   explode("\n", $source);
        $tree       =   array();


        # пройти по строкам
        #
        foreach( $list as $k => $ls )
        {
            # распарсить строки пачек
            # выдать новый id для новой записи
            #
            $v              =   self::parseline($ls);
            #
            $v['id']        =   $v['id']===null && !empty($v['name']) ?  ++user::$counter : $v['id'];
            $v['user']      =   user::$id;
            $v['project']   =   pack::$project;
            $v['order']     =   $k;
            $v['file']      =   isset(pack::$list[ $v['id'] ])?  pack::$list[ $v['id'] ]['file']:  0;
            #
            #
            $tree[]  =  $v;
        }


        # заменить ветку в деревe
        # создать новый лог
        #
        pack::$tree[ pack::$project ]   =   $tree;
        #
        $newlog     =   self::toLog();
        

        
        // ui::vd( res::$ret['treeText'] );
        // ui::vd( $oldlog );
        // ui::vd( $newlog );
        // ui::vd( $oldlog == $newlog, 1 );
        // die;
        

        # сохранить новое дерево проекта
        #
        self::dbSave($oldlog, $newlog);
        
    }


    


    # сохранить записи в базу
    #
    private static function dbSave($oldlog, $newlog)
    {
        if ( $oldlog == $newlog )  return;


        # сохранить в лог
        #
        // db::query("
        //     INSERT INTO `log` (
        //          `user`
        //         ,`author`
        //         ,`author_email`
        //         ,`target`
        //         ,`row`
        //         ,`json`
        //     )
        //     VALUES (
        //         " .db::v(user::$id). "
        //         " .db::v(0). "
        //         " .db::v('0'). "
        //         " .db::v('pack'). "
        //         " .db::v(null). "
        //         " .db::v($newlog). "
        //     )
        // ");
        


        # создать записи пачек
        #
        $rows = '';
        foreach( pack::$tree as $list )
        {
            foreach( $list as $pack )
            {
                $row = '';
                foreach($pack as $v)    $row .= ','. db::v($v);
                $rows .= ',('. substr($row, 1). ')'. "\n";
            }
        }
        $rows = substr($rows, 1);


        
        // # обновить дерево
        // #
        // db::query("DELETE FROM `pack` WHERE `user` = " .db::v(user::$id) );
        
        db::query("-
            INSERT INTO `pack` (
                 `user`
                ,`id`
                ,`project`
                ,`space`
                ,`name`
                ,`order`
                ,`file`
            )
            VALUES
            " .$rows. "
        ");

        ui::vd('Обновить дерево хозяина');


        die;

        // ui::vdd($rows);

        # создать актуальное дерево проекта
        #
        db::query("CREATE TEMPORARY TABLE `rows`  " .implode("\nUNION\n", $rows) );
        

        # добавить новые записи
        #
        db::query("
            INSERT INTO `pack` ( `name`, `id5` )
            SELECT
                `name`, `id5`
            FROM
                `rows`
            WHERE
                `id` = 0
        ");
        

        # получить id добавленных записей
        #
        db::query("
            UPDATE
                `rows`
                    JOIN `pack`     ON `rows`.`id5` = `pack`.`id5`
            SET
                `rows`.`id` =   `pack`.`id`
        ");

        
        // $rows = db::select("SELECT *  FROM `rows` ");
        // ui::vd($rows, 1);
        

        # обновить записи пачек
        #
        db::query("
            UPDATE
                `pack`
                    JOIN `rows`     ON `pack`.`id` = `rows`.`id`
            SET
                    `pack`.`name`      =   `rows`.`name`
                ,`pack`.`parent`    =   IF(`rows`.`parent5` IS NULL, " .db::v(self::$id). ",  (SELECT `id`  FROM `rows` as `r1`  WHERE `id5` = `rows`.`parent5`  LIMIT 1) )
                ,`pack`.`order`     =   `rows`.`order`
                ,`pack`.`user`      =   `rows`.`user`
                ,`pack`.`id5`       =   NULL
        ");
        

        # удалить не актуальные пачки, которых нет в текущих записях
        #
        $currentPack    =   self::getChildrenList( self::$id, [-1] );
        #
        db::query("
            DELETE
            FROM
                `pack`
            WHERE
                `id` IN (" .implode(',', $currentPack). ")
                AND `id` NOT IN (SELECT `id`  FROM `rows`)
        ");

    }


}