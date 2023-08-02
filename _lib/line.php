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
        $this->file =   db::one("SELECT *  FROM `file`  WHERE `id` = " .db::v($fileId));
        db::cast($this->file, ['int'=>['id']]);
        #
        #
        if ( empty($this->file) )   return;



        # получить все записи из базы
        #
        db::query("
            SELECT
                *
            FROM
                `line`
            WHERE
                `file` = " .db::v($this->file['id']). "
            ORDER BY
                `order`
        ");

        while( $v = db::fetch() )
        {
            db::cast($v, array('int'=>['file', 'order']));

            $this->list[ $v['id5'] ] = $v;
            $this->parent[ $v['parent5'] ] = $v['id5'];
        }
        
    }


    public function asText()
    {
        $content = '';

        foreach( $this->list as $v )
        {
            $content    .=  "\n" .str_repeat(' ', $v['space']). $v['content'];
        }

        return substr($content, 1);
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
        url::redir( url::$dir[0] . url::fset(['save'=>time()]) );
    }


        
        # распарсить пришедшее дерево проекта
        # и передать на сохранение в базу
        #
        private function makeRows($text)
        {

            # разбить текст по-строчно, каждая пачка на своей строке
            # вспомогательные переменные
            #
            $tree       =   strip_tags($text, '<img>,<h1>,<h2>,<h3>,<h4>,<h5>,<hr>');
            $tree       =   strtr($text, ["\r"=>'', "\t"=>'    ']);
            $list       =   explode("\n", $tree);
            $lines      =   array();
            $rows       =   array();
            
            // load::vd($list);


            # пройти по строкам
            #
            foreach( $list as $k => $content )
            {

                # отрезать лишние пробелы справа
                # определить количество пробелов слева
                preg_match("#^\s+#", $content, $space);
                $content      =   rtrim($content);
                

                # параметры текущей записи 1
                #
                $file       =   $this->file['id'];
                $order      =   $k + 1;
                $id5        =   md5( trim($content) .$k );
                $space      =   isset($space[0])  ?  strlen($space[0])  :   0;
                $content    =   ltrim($content);
                

                # вспомогательная переменная
                #
                $lines[ $id5 ]  =   $space;
                #
                $parent5    =   $this->findParent5($lines, $space);
                

                # все записи запись
                #
                $rows[] = "
                    SELECT 
                          " .db::v($file).       "   as `file`
                        , " .db::v($space).      "   as `space`
                        , " .db::v($content).    "   as `content`
                        , " .db::v($order).      "   as `order`
                        , " .db::v($id5).        "   as `id5`
                        , " .db::v($parent5).    "   as `parent5`
                ";
                
            }
            
            # сохранить записи в бд
            #
            $this->dbSave($rows);
        }

            
            # найти родителя5
            #
            private function findParent5($lines, $space)
            {
                $reverse    =   array_reverse($lines);
                
                foreach( $reverse as $key => $indent )
                {
                    if ( $indent < $space )   return $key;
                }
            
                return null;
            }



        
        # сохранить записи в базу
        #
        private function dbSave($rows)
        {
            
            # удалить текущие записи
            # добавить новые записи
            #
            db::query("DELETE FROM `line`  WHERE `file` = " .db::v($this->file['id']) );
            
            db::query("
                INSERT INTO `line` (
                      `file`
                    , `space`
                    , `content`
                    , `order`
                    , `id5`
                    , `parent5`
                )
                " .implode("\nUNION\n", $rows)
            );
            
        }

}