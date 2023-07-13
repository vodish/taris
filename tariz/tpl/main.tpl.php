<?php
if ( url::$path == '/' )    url::redir('/r/vodish');

load::$layout   =   'default.tpl.php';
load::$title    =   'Tariz';




# стартовый файл
#
$_cur   =   db::one("SELECT * FROM `row`  WHERE `key` = " .db::v(url::$level[1]). " "); 

function jsonToArr( $json )
{
    $arr   =   json_decode($json, 1);
    $arr   =   $arr ? $arr: array();
    
    return $arr;
}

function sqlIn( $arr )
{
    if ( empty($arr) )  return '-1';

    foreach($arr as &$v)   $v = db::v($v);
    
    return $arr;
}

$_loc   =   jsonToArr($_cur['loc']);
$_rows  =   jsonToArr($_cur['rows']);


# запросить связанные записи
#
$sqlin  =   sqlIn( array_merge($_loc, $_rows) );

db::query("SELECT *  FROM `row`  WHERE `key` IN (" .implode(',', $sqlin). ") ") ;

for( $list=[];  $v = db::fetch();  $list[ $v['key'] ] = $v );



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
    $tree   =   $str;
    $tree   =   str_replace("\r", '', $tree);

    $list   =   explode("\n", $tree);
    $insert =   array();
    $rows   =   array();

    // load::vd($list);

    
    foreach( $list as $k => $v )
    {
        if ( empty($v) )    continue;

        $md5add = md5( session_id() . time() . $k );
        
        # распарсить название пачки
        #
        preg_match("#^\s+#", $v, $level);
        preg_match("#\s\d+$#", $v, $id);
        #
        $level      =   isset($level[0]) ?  $level[0] :  '';
        $id         =   isset($id[0]) ?  trim($id[0]) : '';
        $level1     =   strlen($level);
        $id1        =   strlen($id);
        
        $name       =   substr($v, $level1, strlen($v) - $level1 - $id1 );
        $name       =   trim($name);
        

        # определить родителя
        #
        $rows1      =   $rows;
        $parent     =   null;
        #
        while ( $pop = array_pop($rows1) )
        {
            if ( $pop['level1'] < $level1 )
            {
                $parent = $pop['md5add'];
                break;
            }
        }

        // load::vd('<hr>');


        # добавить запись
        #
        $rows[ $md5add ] = array(
            'md5add'    =>  $md5add,
            'level1'    =>  $level1,
            'parent'    =>  '',

            'level'     =>  $level,
            'name'      =>  $name,
            'id'        =>  $id ?? null,

            'parent'    =>  $parent,
            'order'     =>  $k,
        );
        
        // load::vd($m, 1);
        // echo '<hr>';
    }


    

    load::vd($rows);

}

saveTree($tree, 1);

?>


















<div class="flex1" >
    
    <div class="list">
        <?

        foreach( $_rows = [] as $key )
        {
            $v = $list[ $key ];
            ?>
            <div>
                <?
                if ( $v['type']=='row' )
                {
                    echo '<div class="key">#' .$v['key']. '</div>';
                    echo '<div class="message">' .$v['message']. '</div>';
                }
                elseif ($v['type']=='file')
                {
                    echo '<div class="key">#' .$v['key']. '</div>';
                    echo '<a class="file" href="./' .$v['key']. '">' .$v['name']. '</a>';
                }
                ?>
            </div>
            <?
        }
        ?>

    </div>
</div>

<br>
<br>
<br>



<?

// load::vd($_cur);
// load::vd($_rows);
// load::vd($_loc);
// load::vd($list);

?>

