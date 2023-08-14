<?php
load::$layout   =   'default.tpl.php';


# пачки пользователя
#
$start          =   (int)url::$level[0];
$pack           =   new pack($start);

# не найден пользователь
#
if ( ! $pack->user )    url::redir("/");


# доступные профили
#
user::dbList();


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



# права
#
$access =   new access($pack);
#
#
$access->actionSave();
$access->actionCreateLink();



# записи
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
        
        <?= $start == $proId  && isset($pack->bc[1]) && !isset(url::$level[1])  ? '<a href="' .url::$dir[0].     '?actionProjectCansel">- Проект</a>' : '' ?>
        <?= $start != $proId && !isset(url::$level[1]) ? '<a href="' .url::$dir[0]. '?actionProjectCreate">+ Проект</a>' : '' ?>

    </div>
</div>
<?







# обзор проекта
#
if ( !isset(url::$level[1]) )
{
    ?>
    <div class="pro">
        <div class="tree">
            <?= $project->asTree( $proId ) ?>
        </div>
        <div class="file">
            <?
            foreach($line->list as $v)  echo $v['view'];
            ?>
        </div>
    </div>
    
    <script>
        setTimeout(()=>{ $('#saved').css('display', 'none') }, 2000)
        
        document.addEventListener('keydown', (e) => {
            if ( ['KeyS'].includes(e.code)  &&  (e.ctrlKey || e.metaKey) ) {
                e.preventDefault()
                $('#edit')[0].click()
            }
        })
    </script>
    <?

}




# редактирование дерева проекта
#
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




# редактирование файла
#
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





# редактирование прав
#
elseif ( url::$level[1] == 'access' )
{

    ?>
    <form action="<?= url::$dir[1] ?>" class="tree" method="post">
        <textarea class="ace" name="access" data-mode="ace/mode/yaml"><?= $project->access_yaml ?></textarea>
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
    

    load::vd(user::$list);
    load::vd($pack->bc);
    load::vd($access->bc);
}



