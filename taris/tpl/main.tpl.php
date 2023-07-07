<?php
load::$layout   =   'default.tpl.php';
load::$title    =   'Tariz';

# стартовый файл
#
if ( url::$path == '/' )    url::redir('/r/start');
#
function getRow($id)
{
    $row   =   file_get_contents(__DIR__. "/res/$id.json" );
    $row   =   json_decode($row, 1);

    return $row;
}

$row = getRow(url::$level[1]);

// load::vdd($row, 0);

?>

<div class="flex1">
    <div class="inc">
        inc
    </div>
    <div class="list">

        <?
        
        foreach( $row['rows'] as $id )
        {
            list( 'name'=>$name, 'type'=>$type )  =  getRow($id);
            
            ?>
            <div>
                <div class="id"><?= $type=='file'?  '<a href="./' .$id. '">' .$id. '</a>' :  $id ?></div>
                
                <span class="message"><?= $name ?></span>
            </div>
            <?
        }
        ?>

    </div>
</div>




