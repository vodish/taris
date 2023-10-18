<?php
class line
{
    private static $log = [];
    
    static $init    =   false;
    static $list    =   [];
    static $text    =   '';
    static $html    =   '';


    static function dbInit()
    {
        if ( empty(pack::$file) )   return;
        if ( self::$init        )   return;
        
        # инициализация прошла
        self::$init =   true;

        
        # получить все записи из базы
        #
        db::query("
            SELECT  *
            FROM  `line`
            WHERE  `file` = " .db::v(pack::$file). "
            ORDER BY  `order`
        ");
        #
        #
        while( $v = db::fetch() )
        {
            self::$list[]   =   $v['text'];
        }
        
    }

    

    static function text()
    {
        return  line::$text =   implode("\n", line::$list);
    }




    # распарсить пришедшее дерево проекта
    # и передать на сохранение в базу
    #
    static function html()
    {
        $html   =   '';
        $offset =   0;
        
        foreach( self::$list as $str )
        {
            # определить отступ слева
            preg_match("#^\s*#", $str, $space);
            $space  =   isset($space[0]) ?  strlen($space[0]) :  0;
            
            $str    =   ltrim($str);
            $html   .=  self::toHtml($offset, $space, $str);
        }

        return  self::$html =  $html;
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




    
    # сохранить содержание файла
    #
    static function save()
    {
        if ( empty(pack::$start) )          return;
        if ( !isset(req::$param['line']) )  return;


        line::dbInit();
        $log0   =     line::text();


        # подготовить текст
        #        
        $log1   =   req::$param['line'];
        $log1   =   strtr($log1, ["\r" => '', "\t" => '    ']);
        

        # cравнить новый текст с текущим
        #
        #
        if ( $log0 == $log1 ) return;
        

        
        # подключиться к файлу содержания
        # сохранить в лог
        #
        line::setFile();
        #
        db::query("
            INSERT INTO `log` (
                 `user`
                ,`author`
                ,`author_email`
                ,`target`
                ,`row`
                ,`json`
            )
            VALUES (
                 " .db::v(user::$id). "
                ," .db::v( 0) . "
                ," .db::v( '@' ). "
                ," .db::v( 'file' ). "
                ," .db::v( pack::$file ). "
                ," .db::v( $log0 ). "
            )
        ");
        

        

        # обновить записи в базе
        #
        self::$init =   true;
        self::$list =   explode("\n", $log1);
        #
        $rows  =  array();
        foreach( self::$list as $k => $v )   $rows[] =  "(" .db::v(pack::$file). ", " .db::v($v). ", $k)";
        #
        #
        db::query("DELETE FROM `line`  WHERE `file` = " .db::v(pack::$file) );
        #
        db::query("
            INSERT INTO `line` (
                 `file`
                ,`text`
                ,`order`
            )
            VALUES
            " .implode("\n,", $rows). "
        ");
        
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
    
    
}