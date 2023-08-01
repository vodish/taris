<?php
class line
{
    public $file;
    public $list    =   array();
    public $parent  =   array();


    public function __construct($fileId)
    {
        
        # получить файл из базы
        #
        $this->file =   db::one("SELECT *  FROM `file`  WHERE `id` = " .db::v($fileId). " ");


        # получить все записи из базы
        #
        db::query("
            SELECT
                *
            FROM
                `line`
            WHERE
                `file` = " .db::v($fileId). "
            ORDER BY
                `order`
        ");

        while( $v = db::fetch() )
        {
            db::cast($v, array('int'=>['id', 'parent', 'file', 'order']));

            $this->list[ $v['id'] ] = $v;
            $this->parent[ $v['parent'] ] = $v['id'];
        }
        
    }


    # сохранить новое дерево проекта
    #
    public function actionSave()
    {
        if ( empty($_POST['line']) )    return;

        
        # передать на обработку
        #
        $this->makeRows($_POST['line']);
        

        # редирект на просмотр
        #
        url::redir( url::$path . url::fset(['save'=>time()]) );
    }


        
        # распарсить пришедшее дерево проекта
        # и передать на сохранение в базу
        #
        private function makeRows($text)
        {
            

            # разбить текст по-строчно, каждая пачка на своей строке
            # вспомогательные переменные
            #
            $tree       =   str_replace("\r", '', $text);
            $list       =   explode("\n", $tree);
            $lines      =   array();
            $rows       =   array();
            
            // load::vd($list);


            # пройти по строкам
            #
            foreach( $list as $k => $v )
            {
                if ( empty($v) )    continue;

                # распарсить строки пачек
                #
                preg_match("#^\s+#", $v, $indent5m);
                #
                #
                $indent5    =   isset($indent5m[0])  ?  strlen($indent5m[0])  :   0;
                $hash5      =   md5( trim($v) );
                $order      =   $k;
                #
                #
                # определить родителя из текста
                #
                $lines[ $id5 ]  =   $indent5;
                $parent         =   null;
                $parent5        =   $this->setParent5($lines, $indent5);
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
                ";
                
            }
            



            die;

            # сохранить записи в бд
            #
            //$this->dbSave($rows);

        }


        # определить родителя5
        #
        private function setParent5($lines, $indent5)
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
        private function dbSave($rows)
        {

            
            load::vdd($rows);

            # создать актуальное дерево проекта
            #
            db::query("CREATE TEMPORARY TABLE `l`  " .implode("\nUNION\n", $rows) );
            

            # добавить новые записи
            #
            db::query("
                INSERT INTO `line` ( `name`, `id5` )
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
            // load::vd($rows, 1);
            

            # обновить записи пачек
            #
            db::query("
                UPDATE
                    `pack`
                        JOIN `rows`     ON `pack`.`id` = `rows`.`id`
                SET
                     `pack`.`name`      =   `rows`.`name`
                    ,`pack`.`parent`    =   IF(`rows`.`parent5` IS NULL, " .db::v($this->id). ",  (SELECT `id`  FROM `rows` as `r1`  WHERE `id5` = `rows`.`parent5`  LIMIT 1) )
                    ,`pack`.`order`     =   `rows`.`order`
                    ,`pack`.`user`      =   `rows`.`user`
                    ,`pack`.`id5`       =   NULL
            ");
            

            # удалить не актуальные пачки, которых нет в текущих записях
            #
            $currentPack    =   $this->getChildrenList( $this->id, [-1] );
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