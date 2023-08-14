<?php
load::$layout   =   'default.tpl.php';


# пачки пользователя
#
$start          =   (int)url::$level[0];
$pack           =   new pack($start);


# пользователи
# права
#
$user   =   user::dbList();
$access =   access::dbList($pack->bc);

load::vd($access);
load::vd($user);
#
#
access::actionSave($pack->project);
access::actionCreateLink();





# не найден пользователь
#
if ( ! $pack->user )    url::redir("/");


# проект
#
$proId          =   $pack->project;
$project        =   new project($pack);
load::$title    =   $project->name;
#
#
$project->actionSave();
$project->actionCreate();
$project->actionCansel();


# записи
#
$line   =   new line($pack);
#
#
$line->actionSave();





?>
<div class="nav1">
    <div class="bc">
        <a href="/" class="logo"><b>T</b>ari<b>Z</b></a>
        <?
        $bcProject  =   array_reverse($project->bc);

        foreach( $bcProject as $v )
        {
            $v  =   $pack->list[ $v ];
            ?>
            <i>/</i>
            <a href="/<?= $v['id'] ?>" class="<?= $v['id']==$proId && !isset(url::$level[1]) ? 'active': '' ?>"><?= $v['name'] ?></a>
            <?
        }

        if ( $start != $proId ) {
            echo '<i>/</i>';
            echo '<a href="/' .$start. '" class="current">' .$pack->list[$start]['name']. '</a>';
        }
        ?>
    </div>
    
    <div class="opt">
        <?
        # отчет по операции
        if ( isset($_SESSION['save']) ) { unset($_SESSION['save']); echo '<i class="save" id="saved">Saved</i>'; }
        ?>
        
        <a href="<?= url::$dir[0]. (@url::$level[1]!='line' ? '/line': '') ?>" class="<?= @url::$level[1]=='line'? 'active': '' ?> b" id="edit">Записи</a>
        <i class="sep"></i>
        <a href="<?= url::$dir[0]. (@url::$level[1]!='tree' ? '/tree': '') ?>" class="<?= @url::$level[1]=='tree'? 'active': '' ?>">Дерево</a>
        <a href="<?= url::$dir[0]. (@url::$level[1]!='access' ? '/access': '') ?>" class="<?= @url::$level[1]=='access'? 'active': '' ?>">Доступ</a>
        
        <?= $start == $proId  && isset($pack->bc[1]) && !isset(url::$level[1])  ? '<a href="' .url::$dir[0].     '?actionProjectCansel">-&nbsp;Проект</a>' : '' ?>
        <?= $start != $proId && !isset(url::$level[1]) ? '<a href="' .url::$dir[0]. '?actionProjectCreate">+&nbsp;Проект</a>' : '' ?>

    </div>
</div>
<?

# обзор проекта
# редактирование дерева проекта
# редактирование файла
# ностройка прав пачки
#
if      ( !isset(url::$level[1]) )      $tpl    =  '/view.tpl.php';
elseif  ( url::$level[1] == 'tree' )    $tpl    =  '/tree.tpl.php';
elseif  ( url::$level[1] == 'line' )    $tpl    =  '/line.tpl.php';
elseif  ( url::$level[1] == 'access' )  $tpl    =  '/access.tpl.php';
#
#
require_once  __DIR__. $tpl;