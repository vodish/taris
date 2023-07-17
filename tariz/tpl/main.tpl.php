<?php
if ( url::$path == '/' )    url::redir('/t/1');

load::$layout   =   'default.tpl.php';



# определения
#
$pack           =   new pack(1); // все пачки пользователя
#
$projectId      =   (int) url::$level[1];
$project        =   new project($pack, $projectId);
#
#
# операции
#
$project->actionSave();



$textTree       =   $project->getTextTree( $projectId );
load::$title    =   $pack->list[ $projectId ]['name'];



?>
<form method="post">
    <textarea name="tree" style="width: 100%; height: 20em; padding: 5px;"><?= trim($textTree) ?></textarea>
    <p><button>Обновить</button></p>
</form>
<br><br><br>
<?


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