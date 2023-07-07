<?php
if ( url::$path == '/' )    url::redir('/r/start');

load::$layout   =   'default.tpl.php';
load::$title    =   'Tariz';




# стартовый файл
#
$_cur   =   db::one("SELECT * FROM `row`  WHERE `key` = " .db::v(url::$level[1]). " "); 

$_rows  =   json_decode($_cur['rows'], 1);
$_rows  =   $_rows ? $_rows: array("''");
foreach($_rows as &$v)  $v = "'$v'";
#
$_rows  =   db::select("SELECT *  FROM `row`  WHERE `key` IN (" .implode(',', $_rows). ") ") ;

// load::vd($_rows);

/*
одна запись может находится только в одном месте

start
    14
*/


?>

<div class="flex1">
    <div class="inc">
        <div>inc</div>
        <div>inc</div>
        <div>inc</div>
        <div>inc</div>
    </div>
    <div class="list">

        <?
        foreach( $_rows as $v )
        {
            ?>
            <div>
                <?
                if ( $v['type']=='row' )
                {
                    echo '<div class="id">#' .$v['key']. '</div>';
                    echo '<div class="message">' .$v['message']. '</div>';
                }
                elseif ($v['type']=='file')
                {
                    echo '<div class="id"><a href="./' .$v['key']. '">' .$v['name']. '</a></div>';
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




