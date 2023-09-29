<?php
class line
{
    static $init    =   false;
    static $text    =   '';
    static $html    =   '';


    static function dbInit()
    {
        if ( empty(pack::$file) )   return;
        if ( self::$init        )   return;
        
        # инициализация прошла
        #
        self::$init =   true;


        # получить все записи из базы
        #
        db::query("
            SELECT  *
            FROM  `line`
            WHERE  `file` = " .db::v(pack::$file). "
            ORDER BY  `order`
        ");

        while( $v = db::fetch() )
        {
            db::cast($v, array('int'=>['file', 'order']));

            self::$text .=  "\n" .str_repeat(' ', $v['space']). $v['text'];
            self::$html .=  $v['html'];
        }
        

        self::$text =   substr(self::$text, 1);
    }


    # сохранить содержание файла
    #
    static function save()
    {
        if ( empty(pack::$start) )          return;
        if ( !isset(req::$param['line']) )  return;

        # подключиться к файлу содержания
        #
        line::setFile();
        

        # сохранить содержание в переменнную
        # сохранить содержание в бд
        #
        line::makeRows(req::$param['line']);
    }



        # добавить файл в базу, если его нету
        # и связать его с текущей пачкой
        #
        private static function setFile()
        {
            if ( !empty(pack::$file) )      return;
            
            db::query("INSERT INTO  `file` (`path`)  VALUES('') ");
            
            pack::$file =   db::lastId();

            db::query("UPDATE `pack`  SET `file` = " .db::v(pack::$file). "  WHERE `id` = " .db::v(pack::$start) );
        }

        
        # распарсить пришедшее дерево проекта
        # и передать на сохранение в базу
        #
        private static function makeRows($newContent)
        {

            # разбить текст по-строчно, каждая пачка на своей строке
            # вспомогательные переменные
            #
            $newContent =   strtr($newContent, ["\r"=>'', "\t"=>"    "]);
            $list       =   explode("\n", $newContent);
            $lines      =   array();
            $rows       =   array();
            $offset     =   0;

            # сбросить содержание
            #
            self::$text =   '';
            self::$html =   '';


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
                $file       =   pack::$file;
                $order      =   $k + 1;
                $id5        =   md5( trim($content) .$k );
                $space      =   isset($space[0])  ?  strlen($space[0])  :   0;
                $content    =   ltrim($content);
                

                # вспомогательная переменная
                # новое представление строки в html с левым отступом
                #
                $lines[ $id5 ]  =   $space;
                $parent5        =   self::findParent5($lines, $space);
                #
                $html           =   self::toHtml($offset, $space, $content);
                
                # актуальное состояние
                #
                self::$text     .=  "\n". $content;
                self::$html     .=  $html;


                # все записи запись
                #
                $rows[] = "
                    SELECT 
                          " .db::v($file).       "   as `file`
                        , " .db::v($space).      "   as `space`
                        , " .db::v($content).    "   as `text`
                        , " .db::v($html).       "   as `html`
                        , " .db::v($order).      "   as `order`
                        , " .db::v($id5).        "   as `id5`
                        , " .db::v($parent5).    "   as `parent5`
                        , 0   as `user`
                ";

            }
            
            

            # обновить данные состояния
            #
            self::$init =   true;
            self::$text =   substr(self::$text, 1);


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
            private static function toHtml(int &$offset, int $space, string $content)
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
            db::query("DELETE FROM `line`  WHERE `file` = " .db::v( pack::$file ) );
            
            db::query("
                INSERT INTO `line` (
                      `file`
                    , `space`
                    , `text`
                    , `html`
                    , `order`
                    , `id5`
                    , `parent5`
                    , `user`
                )
                " .implode("\nUNION\n", $rows)
            );
            
        }

}