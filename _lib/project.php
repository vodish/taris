<?php
class project
{
    public $id;
    /**  @var pack $pack */
    public $pack;



    public function __construct($id, pack &$pack)
    {
        $this->id       =   $id;
        $this->pack     =   $pack;
    }


    # получить дерево проекта как текст
    #
    public function getTextTree( $start,  $level=0,  $text='' )
    {
        if ( !isset($this->pack->parent[ $start ]) )  return $text;


        foreach( $this->pack->parent[ $start ] as $id )
        {
            $text   .=  str_repeat(" ", $level*4).  $this->pack->list[ $id ]['name']. ' ' .$id. "\n";

            $text   =   $this->getTextTree($id, ($level+1), $text);
        }


        return $text;
    }


    # получить дерево проекта как html
    public function getHtmlTree( $start,  $level=0,  $html='' )
    {

        foreach( $this->pack->parent[ $start ] as $id )
        {
            $name   =   $this->pack->list[ $id ]['name'];

            $html   .=  '<div class="name ' .( $id == $this->pack->start ?  'active':  ''). '"><a href="/' .$id. '">' .$name. '</a></div>';

            if ( isset($this->pack->parent[ $id ]) )
            {
                $html   .=  '<div class="sub">';
                $html   =   $this->getHtmlTree($id, ($level+1), $html);
                $html   .=  '</div>';
            }

        }


        return $html;
    }


    # сохранить новое дерево проекта
    #
    public function actionSave()
    {
        if ( empty($_POST['tree']) )    return;

        // load::vdd($_POST);
        

        # сохранить в бд
        #
        $this->saveTree($_POST['tree']);
        

        # редирект на просмотр
        #
        url::redir( url::$path . url::fset(['save'=>time()]) );
    }



    
    
    /*
    CRUD (каждая строка - это своя запись)
    1   create
    2   read
    3   update
    4   delete
    */
    private function saveTree($text)
    {
        $project    =   $this->id;
        $user       =   $this->pack->user;


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
            preg_match("#\s\d+$#", $v, $idm);
            #
            #
            $order          =   $user + $k;
            $id5            =   md5( session_id(). time(). $order );
            $indent5        =   isset($indent5m[0])  ?  strlen($indent5m[0])  :   0;
            $id             =   isset($idm[0])       ?  (int)trim($idm[0])    :   0;
            $name           =   trim( substr($v, $indent5, strlen($v) - $indent5 - strlen($idm[0] ?? '') ) );
            #
            #
            # определить родителя из текста
            #
            $lines[ $id5 ]  =   $indent5;
            $parent         =   $project;
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
                    , " .db::v($project).    "   as `project`
                    , " .db::v($user).       "   as `user`
            ";
            
        }
        

        # сохранить записи в бд
        #
        $this->dbSave($rows);

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



    # сохранить записи в бд
    #
    private function dbSave($rows)
    {

        # создать актуальное дерево проекта
        #
        db::query("CREATE TEMPORARY TABLE `rows`  " .implode("\nUNION\n", $rows) );
        

        # добавить новые записи
        #
        db::query("
            INSERT INTO `pack` ( `name`, `id5` )
            SELECT `name`, `id5`  FROM `rows`  WHERE `id` = 0
        ");
        

        # получить id добавленных записей
        #
        db::query("
            UPDATE
                `rows`
                    JOIN `pack` ON `rows`.`id5` = `pack`.`id5`
            SET
                `rows`.`id` =   `pack`.`id`
        ");

        // $rows = db::select("SELECT *  FROM `rows` ");
        // load::vd($rows);


        # обновить id родителей
        #
        db::query("
            UPDATE
                `rows`
            SET
                `parent`    =   IFNULL((SELECT `id`  FROM `rows` as `r1`  WHERE `id5` = `rows`.`parent5`  LIMIT 1), `parent` )
        ");


        # обновить записи пачек
        #
        db::query("
            UPDATE
                `pack`
                    JOIN `rows` ON `pack`.`id` = `rows`.`id`
            SET
                 `pack`.`name`      =   `rows`.`name`
                ,`pack`.`parent`    =   `rows`.`parent`
                ,`pack`.`order`     =   `rows`.`order`
                ,`pack`.`project`   =   `rows`.`project`
                ,`pack`.`user`      =   `rows`.`user`
                ,`pack`.`id5`       =   NULL
        ");
        


        # удалить не актуальные пачки, которых нет в текущих записях
        #
        db::query("
            DELETE
            FROM
                `pack`
            WHERE
                `id` NOT IN (SELECT `id`  FROM `rows`)
                AND `id` != `project`
        ");

    }


}