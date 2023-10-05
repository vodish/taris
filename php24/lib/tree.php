<?php
class tree
{
    
    private static function parseline($str)
    {
        preg_match("#^\s*#", $str, $_before);
        preg_match("#\s+\d+$#", $str, $_after);
        #
        $space  =   strlen($_before[0]);
        $id     =   empty($_after[0]) ?  null : (int) trim($_after[0]);
        $name   =   mb_substr($str, mb_strlen($_before[0]), -mb_strlen($_after[0]??0));

        // if ( empty(trim($str)) )
        // {
        //     ui::vd($space);
        //     ui::vd($_before);
        //     ui::vdd($str, 1);
        // }

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


    private static function toLog()
    {
        $log    =   array();
        ui::vd(pack::$tree[112]);
        foreach( pack::$tree[112] as $rows )
        {
            foreach( $rows as $r )  $log[] =  $r;
        }
        
        $log    =   json_encode($log, JSON_UNESCAPED_UNICODE);

        return $log;
    }




    # распарсить пришедшее дерево проекта
    # и передать на сохранение в базу
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
        $newlog     =   self::toLog();
        
        
        
        ui::vd( res::$ret['treeText'] );
        ui::vd( $oldlog );
        ui::vd( $newlog );
        ui::vd( $oldlog == $newlog, 1 );
        die;
        


        
        ##############################################################
        # пройти по строкам
        #
        foreach( $list as $k => $v )
        {
            // if ( empty($v) )    continue;

            # распарсить строки пачек
            #
            preg_match("#^\s+#", $v, $indent5m);
            preg_match("#\s\d+$#", $v, $idm);
            #
            #
            $order          =   $user + $k;
            $id5            =   md5( session_id(). time(). $order );
            $indent5        =   isset($indent5m[0])  ?  strlen($indent5m[0])  :   0;
            $id             =   isset($idm[0])       ?  (int)trim($idm[0])    :   0;
            $name           =   trim( substr($v, $indent5, strlen($v) - $indent5 - strlen($idm[0] ?? '') ) );
            $idArr[ $id ]   =   $id;
            #
            #
            # определить родителя из текста
            #
            $lines[ $id5 ]  =   $indent5;
            $parent         =   null;
            $parent5        =   self::setParent5($lines, $indent5);
            #
            # все записи запись
            #
            $rows[] = "
                SELECT 
                        " .db::v($id5).        "   as `id5`
                    , " .db::v($parent5).    "   as `parent5`
                    , " .db::v($id).         "   as `id`
                    , " .db::v($parent).     "   as `parent`
                    , " .db::v($name).       "   as `name`
                    , " .db::v($order).      "   as `order`
                    , " .db::v($user).       "   as `user`
            ";
            
        }
        

        # сохранить записи в бд
        #
        self::dbSave($rows);

        
        # вернуть текущую пачку или пачку проекта
        #
        //return $idArr[ pack::$start ] ?? self::$id;
    }


        # определить родителя5
        #
        private static function setParent5($lines, $indent5)
        {
            $reverse    =   array_reverse($lines);
            
            foreach( $reverse as $key => $indent )
            {
                if ( $indent < $indent5 )   return $key;
            }
        
            return null;
        }


    


    # сохранить записи в базу
    #
    private static function dbSave($rows)
    {
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


        # получить текущий список записей проекта
        #
        private static function getChildrenList($start, $list=[])
        {
            $children   =   pack::$parent[ $start ] ??  array();
        
            foreach( $children as $id )
            {
                $list[]     =   $id;
                $isProject  =   pack::$list[ $id ]['is_project'];
                $sub        =   pack::$parent[ $id ] ?? null;

                if ( !$isProject  && isset($sub) )
                {
                    $list   =   self::getChildrenList($id, $list);
                }
            }
            
            return $list;
        }

}