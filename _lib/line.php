<?php
class line
{
    /**  @var pack $pack */
    private $pack;

    public $file;
    public $list    =   array();
    public $parent  =   array();


    public function __construct(pack &$pack)
    {
        $this->pack =   $pack;
        
        # получить файл из базы
        #
        $this->file =   db::one("SELECT *  FROM `file`  WHERE `id` = " .db::v($pack->list[ $pack->start ]['file']));
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

    # получить все строки в виде текста
    #
    public function asText()
    {
        $content = '';

        foreach( $this->list as $v )
        {
            $content    .=  "\n" .str_repeat(' ', $v['space']). $v['content'];
        }

        return substr($content, 1);
    }



    private function asView($content, &$indent, &$space)
    {
        # приведение текста к разбивки по строчно
        # вспомогательная функция для экранирования тегов
        #
        $tags       =   ["pre", "img", "a", "h1", "h2", "h3", "h4", "hr", "b", "i", "s" ];
        $tagsS      =   '<' .implode('><', $tags). '>';
        load::vdd($text);
        #
        $bracket_save = function ($m) use ($tags) {
            echo $m[1]. ' - '. $m[0]. "\n";
            if ( in_array($m[1], [$tags]) )   return $m[0];
            return "&lt;". $m[1]. $m[2];
        };
        $text       =   preg_replace_callback('/<([^>]+?)(\s|$)/i', $bracket_save, $text);  # заменить открывающую скобку, если не тег
        $text       =   strip_tags($text, $tagsS);
        



        # экранировать лишние скобки <>

        # вернуть тег строку

        if ( substr($content, 0, 4) == '<pre' ) {
            $relSpace   =   $space;
            $view       =   $this->pre(['space'=>$relSpace, 'content'=>$content]);
        }
        elseif ( $content == '</pre>' ) {
            $relSpace   =   0;
            $view       =   $content;
        }
        else {
            $view       =   $this->div(['space'=>$space-$relSpace, 'content'=>$content]);
        }

        return $view;
    }

    # напечатать тег <pre>
    #
    public function pre($line)
    {
        $echo   =   $line['content'];
        $echo   =   preg_replace('#style="[^"]+"#', '', $echo);
        $echo   =   $line['space'] ?  preg_replace('#>$#', ' style="margin-left: ' .$line['space']. 'ch;">', $echo):  $echo;
        
        return $echo;
    }
    # напечатать тег <div>
    #
    public function div($line)
    {
        $style  =   $line['space'] ?  ' style="margin-left: ' .$line['space']. 'ch;"' :  '';

        $echo   =   "<div{$style}>{$line['content']}</div>";
        
        return $echo;
    }


    # сохранить содержание файла
    #
    public function actionSave()
    {
        if ( empty($_POST['line']) )    return;

        # добавить файл в базу
        #
        $this->addFile();
        
        # передать на обработку
        #
        $this->makeRows($_POST['line']);
        

        # редирект на просмотр
        #
        url::redir( url::$dir[0],  null, ['save'=>time()] );
    }



        # добавить файл в базу, если его нету
        # и связать его с текущей пачкой
        #
        private function addFile()
        {
            if ( !empty($this->file) )  return;

            db::query("INSERT INTO  `file` (`path`)  VALUES('') ");

            $this->file['id']   =   db::lastId();

            db::query("UPDATE `pack`  SET `file` = " .db::v($this->file['id']). "  WHERE `id` = " .db::v($this->pack->start) );
            

            return $this->file;
        }

        
        # распарсить пришедшее дерево проекта
        # и передать на сохранение в базу
        #
        private function makeRows($text)
        {

            # разбить текст по-строчно, каждая пачка на своей строке
            # вспомогательные переменные
            #
            $text       =   strtr($text, ["\r"=>'', "\t"=>"    "]);
            $list       =   explode("\n", $text);
            $lines      =   array();
            $rows       =   array();
            $indent     =   0;

            // load::vdd($text);


            # пройти по строкам
            #
            foreach( $list as $k => $content )
            {

                # определить количество пробелов слева
                # отрезать лишние пробелы справа
                preg_match("#^\s+#", $content, $space);
                $content    =   rtrim($content);


                # параметры текущей записи
                #
                $file       =   $this->file['id'];
                $order      =   $k + 1;
                $id5        =   md5( trim($content) .$k );
                $space      =   isset($space[0])  ?  strlen($space[0])  :   0;
                $content    =   ltrim($content);
                

                # вспомогательная переменная
                #
                $lines[ $id5 ]  =   $space;
                $parent5        =   $this->findParent5($lines, $space);
                

                # представление строки в html с отступом
                #
                $view       =   $this->asView($content, $indent, $space);
                
                load::vd($view);

                # все записи запись
                #
                $rows[] = "
                    SELECT 
                          " .db::v($file).       "   as `file`
                        , " .db::v($space).      "   as `space`
                        , " .db::v($content).    "   as `content`
                        , " .db::v($view).       "   as `view`
                        , " .db::v($order).      "   as `order`
                        , " .db::v($id5).        "   as `id5`
                        , " .db::v($parent5).    "   as `parent5`
                        , 0   as `user`
                ";
                
            }
            
            load::vdd();

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
                    , `view`
                    , `order`
                    , `id5`
                    , `parent5`
                    , `user`
                )
                " .implode("\nUNION\n", $rows)
            );
            
        }

}