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
$accessYaml     =   $proBc[0]['access_yaml'];
load::$title    =   $proBc[0]['name'];
#
$project        =   new project($pack);
#
#
$project->actionSave();
$project->actionCreate();
$project->actionCansel();



# права
#
$access         =   new access($pack);
#
#
$access->actionSave();
$access->actionCreateLink();



# записи
$line        =   new line($pack);
#
#
$line->actionSave();




# стереть отчет по операции








?>
<div class="nav1">
    <div class="bc">
        <a href="/" class="logo"><b>T</b>ari<b>Z</b></a>
        <?
        foreach( array_reverse($proBc) as $v )
        {
            ?>
            <i>/</i>
            <a href="/<?= $v['id'] ?>" class="<?= $v['id']==$proId && !isset(url::$level[1]) ? 'active': '' ?>"><?= $v['name'] ?></a>
            <?
        }

        if ( @url::$level[1] == 'line' && $start != $proId ) {
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
        
        <a href="<?= url::$dir[0]. (@url::$level[1]!='line' ? '/line': '') ?>" class="<?= @url::$level[1]=='line'? 'active': '' ?> b">Записи</a>
        <i class="sep"></i>
        <a href="<?= url::$dir[0]. (@url::$level[1]!='tree' ? '/tree': '') ?>" class="<?= @url::$level[1]=='tree'? 'active': '' ?>">Дерево</a>
        <a href="<?= url::$dir[0]. (@url::$level[1]!='access' ? '/access': '') ?>" class="<?= @url::$level[1]=='access'? 'active': '' ?>">Доступ</a>
        
        <?= $start == $proId  && isset($proBc[1]) && !isset(url::$level[1])  ? '<a href="' .url::$dir[0].     '?actionProjectCansel">- Проект</a>' : '' ?>
        <?= $start != $proId && !isset(url::$level[1]) ? '<a href="' .url::$dir[0]. '?actionProjectCreate">+ Проект</a>' : '' ?>

    </div>
</div>

<script>
    setTimeout(()=>{ $('#saved').css('display', 'none') }, 2000)
</script>

<?
if ( !isset(url::$level[1]) )
{
    ?>
    <div class="pro">
        <div class="tree">
            <?= $project->getHtmlTree( $proId ) ?>
        </div>
        <div class="file">
            <?

            // load::vd( $pack->bc );

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
        <textarea class="ace" name="tree" data-mode="ace/mode/yaml"><?= trim($project->asText( $proId )) ?></textarea>
        <div class="submit">
            <div></div>
            <button class="save" id="btn-save">Сохранить</button>
        </div>
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
        <textarea class="ace" name="line" data-mode="ace/mode/html"><?= $line->asText() ?></textarea>
        <div class="submit">
            <div></div>
            <button class="save" id="btn-save">Сохранить</button>
        </div>
    </form>

    <?
    echo '<script src="' .load::makefile('/t/ace/ace.js', 'inc/ace/ace.js', true, false). '"></script>'. "\n";
    echo '<script src="' .load::makefile('/t/ace/mode-html.js', 'inc/ace/mode-html.js', true, false). '"></script>'. "\n";
    echo '<script src="' .load::makefile('/t/ace/emmet.js', 'inc/ace/emmet.js', true, false). '"></script>'. "\n";
    echo '<script src="' .load::makefile('/t/ace/ext-emmet.js', 'inc/ace/ext-emmet.js', true, false). '"></script>'. "\n";
    
    echo '<script src="' .load::makefile('/t/_page.js', '_page.js'). '"></script>' . "\n";
}

elseif ( url::$level[1] == 'access' )
{
    
    $site   =   url::site(). '/' .$start;
    ?>
    
    <form action="<?= url::$dir[1] ?>" class="tree" method="post">
        <textarea class="ace" name="access" data-mode="ace/mode/yaml"><?= $accessYaml ?></textarea>
        <div class="submit">
            <a href="<?= url::$dir[1]. '?createAccessLink' ?>">Добавить ссылку доступа</a>
            <button class="save" id="btn-save">Сохранить</button>
        </div>
    </form>

    <?
    echo '<script src="' .load::makefile('/t/ace/ace.js', 'inc/ace/ace.js', true, false). '"></script>';
    echo '<script src="' .load::makefile('/t/ace/mode-yaml.js', 'inc/ace/mode-yaml.js', true, false). '"></script>';
    // echo '<script src="' .load::makefile('/t/ace/theme-tomorrow_night.min.js', 'inc/ace/theme-tomorrow_night.min.js', true, false). '"></script>';
    
    echo '<script src="' .load::makefile('/t/_page.js', '_page.js'). '"></script>';
    
}



