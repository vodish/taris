<?php
if ( url::$path == '/' )    url::redir('/p/1');

load::$layout   =   'default.tpl.php';
load::$title    =   'Tariz';


# стартовая пачка
#
$project    =   url::$level[1];
$tree   =   db::select("SELECT *  FROM `pack`  WHERE " .db::v($project). " = `project` ");

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


function saveTree($str, $project=1)
{
    # разбить по строчно
    #
    $tree   =   $str;
    $tree   =   str_replace("\r", '', $tree);

    $insert =   array();
    $rows   =   array();
    $list   =   explode("\n", $tree);
    
    // load::vd($list);

    
    foreach( $list as $k => $v )
    {
        if ( empty($v) )    continue;

        # распарсить название пачки
        #
        preg_match("#^\s+#", $v, $indent5);
        preg_match("#\s\d+$#", $v, $id);
        #
        #
        $id5        =   md5( session_id() . time() . $k );
        $indent5    =   isset($indent5[0])  ?  strlen($indent5[0])  :   0;
        $id         =   isset($id[0])       ?  trim($id[0])         :   null;
        
        $name       =   substr($v, $indent5, strlen($v) - $indent5 - strlen($id) );
        $name       =   trim($name);
        #
        #
        # определить родителя
        #
        $parent5    =   null;
        $rows1      =   $rows;
        #
        while ( $pop = array_pop($rows1) )
        {
            if ( $pop['indent5'] < $indent5 )
            {
                $parent5 = $pop['id5'];
                break 1;
            }
        }
        #
        #
        # все записи запись
        #
        $rows[ $id5 ] = array(
            'id5'       =>  $id5,
            'parent5'   =>  $parent5,
            
            'indent5'    =>  $indent5,
            'indent5'     =>  $indent5,
            
            'id'        =>  $id,
            'parent'    =>  null,
            'name'      =>  $name,
            'order'     =>  $k,
        );
        #
        #
        # записи к добавлению
        #
        if ( !$id )
        {
            $insert[] = "SELECT " .db::v($project). " as `project`, " .db::v($name). " as `name`,  NULL as `id`,  " .db::v($id5). " as `id5`,  " .db::v($parent5). " as `parent`,  " .db::v($k). " as `order`";
        }
    }

    //load::vdd($rows);

    # добавить записи
    #
    if ( 0 && $insert )
    {
        # 1. создать временную таблицу
        #
        db::query("CREATE TEMPORARY TABLE `insert`  " .implode("\nUNION\n", $insert) );
        #
        // load::vdd( $insert );
        #
        #
        # 2. добавить записи
        #
        db::query("
            INSERT INTO `pack` (`project`, `name`, `order`, `id5` )
            SELECT              `project`, `name`, `order`, `id5`  FROM `insert`
        ");
        #
        #
        # 3. получить идишники новых записей
        #
        $updId  =   db::query("
            SELECT
                  `id`
                , `id5`
            FROM
                `pack`
            WHERE
                `id5` IN (SELECT `id5` FROM `insert`)
            
        ");
        for( $updId = [];  $v = db::fetch();  $updId[ $v['id5'] ] = $v['id'] );
        #
        #
        # 4. проставить новые идишники
        #
        foreach( $updId as $id1 => $id )
        {
            $rows[ $id1 ]['id'] = $id;
        }
        #
        #
        
    }

    # 5. проставить новых родителей
    #
    

    // load::vdd($rows);


    

}

saveTree($tree, (int)$project);





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
            <td>indent5</td>
            <td>number</td>
        </tr>
        <tr>
            <td>name</td>
            <td>val</td>
        </tr>
        <tr>
            <td>id</td>
            <td>?</td>
        </tr>
        <tr>
            <td>order</td>
            <td>val</td>
        </tr>
        <tr>
            <td>project</td>
            <td>number</td>
        </tr>
        

        <tr>
            <td></td>
            <td></td>
        </tr>
        
        <tr>
            <td>parent5</td>
            <td>-> id5</td>
        </tr>
        <tr>
            <td>parent</td>
            <td>? || projectId</td>
        </tr>
        </table>
    </div>
</div>