<?php
load::$layout   =   'default.tpl.php';


# все пачки пользователя
#
$start          =   (int)url::$level[0];
$pack           =   new pack($start);


# если пачка не найдена
#
if ( ! $pack->user )    url::redir("/");




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
        <a href="/" class="logo"><b>T</b>ari<b>Z</b></a>
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
        <a href="<?= url::$dir[0] ?>" class="<?= !isset(url::$level[1])? 'active': '' ?>">Проект</a>
        <a href="<?= url::$dir[0]. '/tree' ?>" class="<?= @url::$level[1]=='tree'? 'active': '' ?>">Дерево</a>
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
    <form class="tree" method="post">
        <textarea class="ace" name="tree"><?= trim($project->getTextTree( $proId )) ?></textarea>
        <button class="save">Сохранить</button>
    </form>

    <?
    echo '<script src="' .load::makefile('/t/ace/ace.js', 'inc/ace/ace.js', true, false). '"></script>'. "\n";
    // echo '<script src="' .load::makefile('/t/ace/mode-html.js', 'inc/ace/mode-html.js', true, false). '"></script>'. "\n";
    
    // echo '<script src="' .load::makefile('/t/ace/emmet.js', 'inc/ace/emmet.js', true, false). '"></script>'. "\n";
    // echo '<script src="' .load::makefile('/t/ace/ext-emmet.js', 'inc/ace/ext-emmet.js', true, false). '"></script>'. "\n";
    
    // echo '<script src="' .load::makefile('/t/ace/mode-css.js', 'inc/ace/mode-css.js', true, false). '"></script>'. "\n";
    // echo '<script src="' .load::makefile('/t/ace/worker-html.js', 'inc/ace/worker-html.js', true, false). '"></script>'. "\n";
    // echo '<script src="' .load::makefile('/t/ace/worker-css.js', 'inc/ace/worker-css.js', true, false). '"></script>'. "\n";
    
    // echo '<script src="' .load::makefile('/t/ace/theme-tomorrow_night.min.js', 'inc/ace/theme-tomorrow_night.min.js', true, false). '"></script>'. "\n";
    
    echo '<script src="' .load::makefile('/t/_page.js', '_page.js'). '"></script>' . "\n";

    
}

elseif ( url::$level[1] == 'rows' )
{
    ?>
    <form class="tree" method="post">
        <textarea class="ace" name="rows" data-mode="ace/mode/html"><?//= trim($project->getTextTree( $proId )) ?></textarea>
        <button class="save">Сохранить</button>
    </form>

    <?
    echo '<script src="' .load::makefile('/t/ace/ace.js', 'inc/ace/ace.js', true, false). '"></script>'. "\n";
    echo '<script src="' .load::makefile('/t/ace/mode-html.js', 'inc/ace/mode-html.js', true, false). '"></script>'. "\n";
    
    echo '<script src="' .load::makefile('/t/ace/emmet.js', 'inc/ace/emmet.js', true, false). '"></script>'. "\n";
    echo '<script src="' .load::makefile('/t/ace/ext-emmet.js', 'inc/ace/ext-emmet.js', true, false). '"></script>'. "\n";
    
    echo '<script src="' .load::makefile('/t/_page.js', '_page.js'). '"></script>' . "\n";

    
}


?>