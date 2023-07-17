<?php
if ( url::$path == '/' )    url::redir('/1');

load::$layout   =   'default.tpl.php';


# определения
#
$pack           =   new pack(1); // все пачки пользователя
#
$projectId      =   (int) url::$level[0];
$project        =   new project($pack, $projectId);
#
#
# операции
#
$project->actionSave();


# получить дерево для редактирования
#
$textTree       =   $project->getTextTree( $projectId );
load::$title    =   $pack->list[ $projectId ]['name'];



?>
<div class="nav1">
    <div class="bc">
        <a href="/" class="logo">Tariz</a>
        <i>/</i>
        <a href="">p.karasev@psw.ru</a>
        <i>/</i>
        <a href="" class="active">path 2</a>
    </div>
    
    <div class="opt">
        <a href="<?= url::$dir[0] ?>" class="<?= !isset(url::$level[1])? 'active': '' ?>">Обзор</a>
        <a href="<?= url::$dir[0]. '/tree' ?>" class="<?= @url::$level[1]=='tree'? 'active': '' ?>">Проект</a>
        <a href="<?= url::$dir[0]. '/rows' ?>" class="<?= @url::$level[1]=='rows'? 'active': '' ?>">Записи</a>
    </div>
</div>


<?
if ( !isset(url::$level[1]) )
{

    ?>
    <div class="pro">
        <div class="tree">
            <?= $project->getHtmlTree( $projectId ) ?>
        </div>
        <div class="rows">
            вывести пачку записей
        </div>
    </div>
    
    <?

}
elseif ( url::$level[1] == 'tree' )
{
    ?>
    <form method="post">
        <textarea name="tree" style="width: 100%; height: 20em; padding: 5px;"><?= trim($textTree) ?></textarea>
        <p><button>Обновить</button></p>
    </form>
    <?
}
?>