<?php
load::$layout   =   'default.tpl.php';


# пачки пользователя
#
$start          =   (int)url::$level[0];
$pack           =   new pack($start);

# не найден пользователь
#
if ( ! $pack->user )    url::redir("/");



# проект
#
$proBc          =   $pack->getProjectBc( $start );
$proId          =   $proBc[0]['id'];
$fileId         =   $proBc[0]['file'];
load::$title    =   $proBc[0]['name'];
$project        =   new project($proId, $pack);

# операции проекта
#
$project->actionSave();
$project->actionCreate();
$project->actionCansel();



# записи
#
$line        =   new line( $pack->list[ $start ]['file'] );

# операции записи
#
$line->actionSave();



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
        <!-- <a href="<?= url::$dir[0] ?>" class="<?= !isset(url::$level[1])? 'active': '' ?>">Проект</a> -->
        
        <a href="<?= url::$dir[0]. (@url::$level[1]!='tree' ? '/tree': '') ?>" class="<?= @url::$level[1]=='tree'? 'active': '' ?>">Дерево</a>
        <a href="<?= url::$dir[0]. (@url::$level[1]!='line' ? '/line': '') ?>" class="<?= @url::$level[1]=='line'? 'active': '' ?>">Записи</a>

        <?= $start == $proId  && isset($proBc[1])  ? '<a href="' .url::$dir[0].     '?actionProjectCansel">- Проект</a>' : '' ?>
        <?= $start != $proId && !isset(url::$level[1]) ? '<a href="' .url::$dir[0]. '?actionProjectCreate">+ Проект</a>' : '' ?>
        
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
        <div class="file">
            <?
            foreach($line->list as $v)
            {
                ?>
                <div style="margin-left: <?= $v['space'] ?>ch;"><?= $v['content'] ?></div>
                <?
            }
            ?>
        </div>
    </div>
    
    <?

}
elseif ( url::$level[1] == 'tree' )
{
    ?>
    <form class="tree" method="post">
        <textarea class="ace" name="tree" data-mode="ace/mode/yaml"><?= trim($project->getTextTree( $proId )) ?></textarea>
        <button class="save">Сохранить</button>
    </form>

    <?
    echo '<script src="' .load::makefile('/t/ace/ace.js', 'inc/ace/ace.js', true, false). '"></script>'. "\n";
    echo '<script src="' .load::makefile('/t/ace/mode-yaml.js', 'inc/ace/mode-yaml.js', true, false). '"></script>'. "\n";
    
    // echo '<script src="' .load::makefile('/t/ace/theme-tomorrow_night.min.js', 'inc/ace/theme-tomorrow_night.min.js', true, false). '"></script>'. "\n";
    
    echo '<script src="' .load::makefile('/t/_page.js', '_page.js'). '"></script>' . "\n";

    
}

elseif ( url::$level[1] == 'line' )
{

    // load::vd($line->list);

    ?>
    <form class="tree" method="post">
        <textarea class="ace" name="line" data-mode="ace/mode/yaml"><?= $line->asText() ?></textarea>
        <button class="save">Сохранить</button>
    </form>

    <?

    echo '<script src="' .load::makefile('/t/ace/ace.js', 'inc/ace/ace.js', true, false). '"></script>'. "\n";
    echo '<script src="' .load::makefile('/t/ace/mode-yaml.js', 'inc/ace/mode-yaml.js', true, false). '"></script>'. "\n";
    
    echo '<script src="' .load::makefile('/t/_page.js', '_page.js'). '"></script>' . "\n";

    
}


?>