<?php
class tree
{
    # получить дерево проекта как массив для json
    #
    static function array( $start,  $level=0,  $arr=array() )
    {
        
        $children   =   pack::$parent[ $start ] ??  array();
        

        foreach( $children as $id )
        {
            $name       =   pack::$list[ $id ]['name'];
            $isProject  =   pack::$list[ $id ]['is_project'];
            $sub        =   pack::$parent[ $id ] ?? null;
            
            $arr[]      =   ['id'=>$id, 'project'=>$isProject, 'level'=>$level];;

            pack::toHeap(['id'=>$id, 'name'=>$name]);
            
            
            if ( !$isProject  && isset($sub) )
            {
                $arr   =   self::array($id, ($level+1), $arr);
            }
        }
        
        return $arr;
    }



    # получить дерево проекта как текст
    #
    static function text( $start,  $level=0,  $text='' )
    {
        $children   =   pack::$parent[ $start ] ??  array();
        
        foreach( $children as $id )
        {
            $isProject  =   pack::$list[ $id ]['is_project'];
            $sub        =   pack::$parent[ $id ] ?? null;

            $text       .=  str_repeat(" ", $level*4).  pack::$list[ $id ]['name']. '  ' .$id. "\n";

            if ( !$isProject  && isset($sub) )
            {
                $text   =   self::text($id, ($level+1), $text);
            }
        }


        return $text;
    }



    # сохранить новое дерево проекта
    #
    static function save()
    {
        if ( empty(pack::$start)    )   return;
        if ( empty($_POST['tree'])  )   return;
        
        # передать на обработку
        #
        $packBack   =   self::makeRows($_POST['tree']);
        
        # перечитать пачку
        #
        // pack::init( pack::$start );

    }

        
        # распарсить пришедшее дерево проекта
        # и передать на сохранение в базу
        #
        static function makeRows($text)
        {
            $user       =   pack::$user;


            # разбить текст по-строчно, каждая пачка на своей строке
            # вспомогательные переменные
            #
            $tree       =   str_replace("\r", '', $text);
            $list       =   explode("\n", $tree);
            $lines      =   array();
            $rows       =   array();
            $idArr      =   array();  # массив для проверки уделения текущей пачки
            // ui::vd($list);


            # пройти по строкам
            #
            foreach( $list as $k => $v )
            {
                if ( empty($v) )    continue;

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