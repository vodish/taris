<?php
if ( url::$path == '/' )    url::redir('/r/start');

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

$_dir   =   jsonToArr($_cur['dir']);
$_loc   =   jsonToArr($_cur['loc']);
$_rows  =   jsonToArr($_cur['rows']);


# запросить связанные записи
#
$sqlin  =   sqlIn( array_merge($_loc, $_rows) );

db::query("SELECT *  FROM `row`  WHERE `key` IN (" .implode(',', $sqlin). ") ") ;

for( $list=[];  $v = db::fetch();  $list[ $v['key'] ] = $v );


?>

<div class="loc">
    <?
    echo '<a href="./">UserName</a>';

    foreach( $_dir as $name )
    {
        // $v = $list[ $key ];

        echo '<i class="sep">/</i>';
        echo '<a href="./">' .$name. '</a>';
    }

    echo '<i class="sep">/</i>';
    echo '<span>' .$_cur['name']. '</span>';
    ?>
</div>

<div class="flex1">
    <div class="inc">
        <?
        foreach( $_loc as $key )
        {
            $v = $list[ $key ];
            echo '<div><a href="./' .$v['key']. '">запись #' .$v['key']. '</a></div>';
        }
        // load::vd($_loc);
        ?>
    </div>
    <div class="list">

        <?
        foreach( $_rows as $key )
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

        if ( empty($_rows) )
        {
            echo 'Нету записей.';
        }

        // load::vd($_rows);
        ?>

    </div>
</div>


<?

load::vd($_cur);
// load::vd($_rows);
// load::vd($_loc);
// load::vd($list);

?>

