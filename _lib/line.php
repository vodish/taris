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
                $file       =   $this->file['id'];
                $order      =   $k + 1;
                $id5        =   md5( trim($content) .$k );
                $space      =   isset($space[0])  ?  strlen($space[0])  :   0;
                $content    =   ltrim($content);
                

                # вспомогательная переменная
                #
                $lines[ $id5 ]  =   $space;
                $parent5        =   $this->findParent5($lines, $space);
                

                # представление строки в html с левым отступом
                #
                $view       =   $this->view($offset, $space, $content);
                

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


            # преобразовать строку в безопасный хтмл
            #
            public function view(int &$offset, int $space, string $content)
            {
                # разрешенные теги и аттрибуты
                #
                $tags       =   "(?:pre)|(?:pre .*?)  | (?:a .+) | (?:img .+)  | (?:h1)|(?:h2)|(?:h3)|(?:h4)|(?:hr) | (?:b)|(?:i)|(?:s)";
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