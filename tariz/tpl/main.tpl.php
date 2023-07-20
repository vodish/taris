<?php
load::$layout   =   'default.tpl.php';


# все пачки пользователя
#
$userId         =   1;
$start          =   isset( url::$level[0] ) ?  (int)url::$level[0] :  null;
$pack           =   new pack($userId, $start);


# если пачка не найдена
#
if ( !isset( $pack->list[$start] ) )    url::redir("/$userId");


# определения проекта
#
$proBc          =   $pack->getProjectBc( $start );
$proId          =   $proBc[0]['id'];
load::$title    =   $proBc[0]['name'];
#
$project        =   new project($proId, $pack);


# сохранить новое дерево проекта
#
$project->actionSave();
$project->actionCreate();
$project->actionCansel();



?>
<div class="nav1">
    <div class="bc">
        <a href="/" class="logo">Tariz</a>
        <?
        foreach( array_reverse($proBc) as $v )
        {
            ?>
            <i>/</i>
            <a href="/<?= $v['id'] ?>" class="<?= $v['id']==$proId ? 'current': '' ?>"><?= $v['name'] ?></a>
            <?
        }
        ?>
    </div>
    
    <div class="opt">
        <a href="<?= url::$dir[0] ?>" class="<?= !isset(url::$level[1])? 'active': '' ?>">Обзор</a>
        <a href="<?= url::$dir[0]. '/tree' ?>" class="<?= @url::$level[1]=='tree'? 'active': '' ?>">Проект</a>
        <?= $start == $proId  && isset($proBc[1])  ? '<a href="' .url::$dir[0].     '?actionProjectCansel">- Проект</a>' : '' ?>
        <?= $start != $proId && !isset(url::$level[1]) ? '<a href="' .url::$dir[0]. '?actionProjectCreate">+ Проект</a>' : '' ?>
        <a href="<?= url::$dir[0]. '/rows' ?>" class="<?= @url::$level[1]=='rows'? 'active': '' ?>">Записи</a>
    </div>
</div>


<?
if ( !isset(url::$level[1]) )
{
    # текстовое дерево проекта
    #
    ?>
    <div class="pro">
        <div class="tree">
            <?= $project->getHtmlTree( $proId ) ?>
        </div>
        <div class="rows">
            вывести пачку записей

            <?
            //load::vd($proBc);
            ?>
        </div>
    </div>
    
    <?

}
elseif ( url::$level[1] == 'tree' )
{
    ?>
    <form method="post">
        <textarea name="tree" style="width: 100%; height: 20em; padding: 5px;"><?= trim($project->getTextTree( $proId )) ?></textarea>
        <p><button>Обновить</button></p>
    </form>
    <?
    
}
?>