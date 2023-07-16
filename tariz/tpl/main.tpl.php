<?php
if ( url::$path == '/' )    url::redir('/p/1');

load::$layout   =   'default.tpl.php';
load::$title    =   'Tariz';


# стартовая пачка
#
$project    =   url::$level[1];
$tree       =   db::select("SELECT *  FROM `pack`  WHERE " .db::v($project). " = `project` ");

// load::vdd($tree);




/*
CRUD (каждая строка - это своя запись)
1   create
2   read
3   update
4   delete
*/



$tree = <<<TREE
first
index.php
    _config.php
        url.php
        _route.php
            db.php
            url.php
        load.php
            [ / ]
                main.tpl.php
                    url.php
                    db.php
                    load.php
                default.tpl.php
            [ /data* ]
                data.tpl.php
                    data.php
TREE;

load::vd($tree);
?>
<br><br><br>
<?

function getParent5($lines, $indent5)
{
    $reverse    =   array_reverse($lines);

    // load::vd($indent5);
    // load::vd($lines);
    // load::vd($reverse);
    // echo '<hr>';

    foreach( $reverse as $key => $indent )
    {
        if ( $indent < $indent5 )   return $key;
    }

    return null;
}



function saveTree($str, $project=1)
{
    # разбить по строчно
    #
    $tree   =   str_replace("\r", '', $str);
    $list   =   explode("\n", $tree);
    #
    # вспомогательные переменные
    #
    $lines  =   array();
    $rows   =   array();
    
    // load::vd($list);

    
    foreach( $list as $npp => $v )
    {
        if ( empty($v) )    continue;

        # распарсить строки пачек
        #
        preg_match("#^\s+#", $v, $indent5m);
        preg_match("#\s\d+$#", $v, $idm);
        
        #
        $id5        =   md5( session_id(). time(). $npp );
        $indent5    =   isset($indent5m[0])  ?  strlen($indent5m[0])  :   0;
        $id         =   isset($idm[0])       ?  (int)trim($idm[0])    :   0;
        $name       =   trim( substr($v, $indent5, strlen($v) - $indent5 - strlen($idm[0] ?? '') ) );
        #
        #
        # определить родителя из текста
        #
        $lines[ $id5 ]  =   $indent5;
        $parent     =   $project;
        $parent5    =   getParent5($lines, $indent5);
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
                , " .db::v($npp).        "   as `order`
                , " .db::v($project).    "   as `project`
        ";
        
    }


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
            `parent` =  IFNULL((SELECT `id`  FROM `rows` as `r1`  WHERE `id5` = `rows`.`parent5`  LIMIT 1), `parent` )
    ");


    # записи пачек
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
            ,`pack`.`id5`       =   NULL
    ");
    


    load::vd($rows);


}

// saveTree($tree, (int)$project);





// load::vd($_cur);
// load::vd($_rows);
// load::vd($_loc);
// load::vd($list);

?>

<div class="flex1">
    <div>
        <table class="arr1">
        <tr>
            <td>id5</td>
            <td>md5(str)</td>
        </tr>
        <tr>
            <td>parent5</td>
            <td>-> id5</td>
        </tr>
        <tr>
            <td colspan="2"></td>
        </tr>
        
        <tr>
            <td>id</td>
            <td>?</td>
        </tr>
        <tr>
            <td>parent</td>
            <td>?</td>
        </tr>
        <tr>
            <td colspan="2"></td>
        </tr>
        
        <tr>
            <td>project</td>
            <td>number</td>
        </tr>
        <tr>
            <td>name</td>
            <td>val</td>
        </tr>
        <tr>
            <td>order</td>
            <td>val</td>
        </tr>
        
        </table>
    </div>
</div>