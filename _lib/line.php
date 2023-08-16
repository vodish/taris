<?php
class line
{
    static $file;
    static $list    =   array();
    static $parent  =   array();


    static function dbInit()
    {
        $file   =   pack::$list[ pack::$start ]['file'];

        # получить файл из базы
        #
        self::$file =   db::one("SELECT *  FROM `file`  WHERE `id` = " .db::v($file));
        db::cast(self::$file, ['int'=>['id']]);
        #
        #
        if ( empty(self::$file) )   return;



        # получить все записи из базы
        #
        db::query("
            SELECT
                *
            FROM
                `line`
            WHERE
                `file` = " .db::v(self::$file['id']). "
            ORDER BY
                `order`
        ");

        while( $v = db::fetch() )
        {
            db::cast($v, array('int'=>['file', 'order']));

            self::$list[ $v['id5'] ] = $v;
            self::$parent[ $v['parent5'] ] = $v['id5'];
        }
        
    }

    # получить все строки в виде текста
    #
    static function asText()
    {
        $content = '';

        foreach( self::$list as $v )
        {
            $content    .=  "\n" .str_repeat(' ', $v['space']). $v['content'];
        }

        return substr($content, 1);
    }







    # сохранить содержание файла
    #
    static function actionSave()
    {
        if ( empty($_POST['line']) )    return;

        # добавить файл в базу
        #
        self::addFile();
        
        # передать на обработку
        #
        self::makeRows($_POST['line']);
        

        # редирект на просмотр
        #
        url::redir( url::$dir[0],  null, ['save'=>time()] );
    }



        # добавить файл в базу, если его нету
        # и связать его с текущей пачкой
        #
        private static function addFile()
        {
            if ( !empty(self::$file) )  return;

            db::query("INSERT INTO  `file` (`path`)  VALUES('') ");

            self::$file['id']   =   db::lastId();

            db::query("UPDATE `pack`  SET `file` = " .db::v(self::$file['id']). "  WHERE `id` = " .db::v(pack::$start) );
            

            return self::$file;
        }

        
        # распарсить пришедшее дерево проекта
        # и передать на сохранение в базу
        #
        private static function makeRows($text)
        {

            # разбить текст по-строчно, каждая пачка на своей строке
            # вспомогательные переменные
            #
            $text       =   strtr($text, ["\r"=>'', "\t"=>"    "]);
            $list       =   explode("\n", $text);
            $lines      =   array();
            $rows       =   array();
            $offset     =   0;



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
                $file       =   self::$file['id'];
                $order      =   $k + 1;
                $id5        =   md5( trim($content) .$k );
                $space      =   isset($space[0])  ?  strlen($space[0])  :   0;
                $content    =   ltrim($content);
                

                # вспомогательная переменная
                #
                $lines[ $id5 ]  =   $space;
                $parent5        =   self::findParent5($lines, $space);
                

                # представление строки в html с левым отступом
                #
                $view       =   self::view($offset, $space, $content);
                

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
            

            # сохранить записи в бд
            #
            self::dbSave($rows);
        }

            

            # найти родителя5
            #
            private static function findParent5($lines, $space)
            {
                $reverse    =   array_reverse($lines);
                
                foreach( $reverse as $key => $indent )
                {
                    if ( $indent < $space )   return $key;
                }
            
                return null;
            }


            # преобразовать строку в безопасный хтмл
            #
            public static function view(int &$offset, int $space, string $content)
            {
                # разрешенные теги и аттрибуты
                #
                $tags       =   "(?:pre)|(?:pre .*?)  | (?:a)|(?:a \s .+?)  | (?:img)|(?:img .+?)  | (?:h1)|(?:h2)|(?:h3)|(?:h4)|(?:hr) | (?:b)|(?:i)|(?:s)";
                $attrs      =   "(?:href=) | (?:target=)  | (?:src=)  | (?:class=)";


                # преобразовать все html символы в безопасные
                # todo: не парные теги снова в htmlspecialchars()
                # todo: class="" оставить только для <pre>
                #
                $content    =   htmlspecialchars($content);
                $content    =   preg_replace("/&lt; (\/?) (" .$tags. ") &gt;/x", "<$1$2>", $content);
                $content    =   preg_replace("/(" .$attrs. ") &quot; (.+?) &quot;/x", '$1"$2"', $content);
                

                # отступы с оберткой в тег строки
                #
                if ( substr($content, 0, 4) == '<pre' )
                {
                    $offset     =   $space;
                    $content    =   $space ?  strtr($content, ['<pre'=>'<pre style="margin-left:' .$space. 'ch;"']) :  $content;
                }
                elseif ( $content == '</pre>' )
                {
                    $offset     =   0;
                }
                else
                {
                    $need       =   $space - $offset;
                    $content    =   $need ?  '<div style="margin-left:' .$need. 'ch;">' .$content. '</div>' :  "<div>$content</div>";
                }
                
                
                return $content;
            }



        
        # сохранить записи в базу
        #
        private static function dbSave($rows)
        {

            # удалить текущие записи
            # добавить новые записи
            #
            db::query("DELETE FROM `line`  WHERE `file` = " .db::v(self::$file['id']) );
            
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