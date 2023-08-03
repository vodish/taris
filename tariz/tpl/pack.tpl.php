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
            <a href="/<?= $v['id'] ?>" class="<?= $v['id']==$proId && !isset(url::$level[1]) ? 'active': '' ?>"><?= $v['name'] ?></a>
            <?
        }
        ?>
    </div>
    
    <div class="opt">
        <?= $start == $proId  && isset($proBc[1]) && !isset(url::$level[1])  ? '<a href="' .url::$dir[0].     '?actionProjectCansel">- Проект</a>' : '' ?>
        <?= $start != $proId && !isset(url::$level[1]) ? '<a href="' .url::$dir[0]. '?actionProjectCreate">+ Проект</a>' : '' ?>

        <a href="<?= url::$dir[0]. (@url::$level[1]!='tree' ? '/tree': '') ?>" class="<?= @url::$level[1]=='tree'? 'active': '' ?>">Дерево</a>
        <a href="<?= url::$dir[0]. (@url::$level[1]!='line' ? '/line': '') ?>" class="<?= @url::$level[1]=='line'? 'active': '' ?>">Записи</a>
        <a href="<?= url::$dir[0]. (@url::$level[1]!='access' ? '/access': '') ?>" class="<?= @url::$level[1]=='access'? 'active': '' ?>">Доступ</a>

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
        <textarea class="ace" name="tree" data-mode="ace/mode/yaml"><?= trim($project->asText( $proId )) ?></textarea>
        <div class="submit">
            <div></div>
            <button class="save">Сохранить</button>
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
            <button class="save">Сохранить</button>
        </div>
    </form>

    <?
    echo '<script src="' .load::makefile('/t/ace/ace.js', 'inc/ace/ace.js', true, false). '"></script>'. "\n";
    echo '<script src="' .load::makefile('/t/ace/mode-html.js', 'inc/ace/mode-html.js', true, false). '"></script>'. "\n";
    echo '<script src="' .load::makefile('/t/ace/emmet.js', 'inc/ace/emmet.js', true, false). '"></script>'. "\n";
    echo '<script src="' .load::makefile('/t/ace/ext-emmet.js', 'inc/ace/ext-emmet.js', true, false). '"></script>'. "\n";
    // echo '<script src="' .load::makefile('/t/ace/mode-yaml.js', 'inc/ace/mode-yaml.js', true, false). '"></script>'. "\n";
    
    echo '<script src="' .load::makefile('/t/_page.js', '_page.js'). '"></script>' . "\n";
}

elseif ( url::$level[1] == 'access' )
{

    $table = array(
        ['project'=> 'Проект', 'target'=> 'pavel@karasev.ru', 'data' => date('d.m.Y'), 'type'=> 'only | recursive', 'access'=> 'Owner', 'remove'=>''],
        ['project'=> 'Проект', 'target'=> 'public', 'data' => '', 'type'=> 'only | recursive', 'access'=> 'Read', 'remove'=>''],
        ['project'=> 'Проект', 'target'=> 'vodish@karasev.ru', 'data' => date('d.m.Y'), 'type'=> 'only | recursive', 'access'=> 'Read, Edit', 'remove'=>'Remove'],
        ['project'=> 'Проект', 'target'=> '<input type="text" name="email" placeholder="Ввести емеил" />', 'data' => date('d.m.Y'), 'type'=> 'only | recursive', 'access'=> 'Read, Edit', 'remove'=>''],
        ['project'=> 'Проект', 'target'=> '<a href="' .($hash=md5('hash')). '">' .$hash. '</a>', 'data' => date('d.m.Y'), 'type'=> 'only | recursive', 'access'=> 'Read', 'remove'=>'Remove'],
        ['project'=> 'Проект', 'target'=> md5(rand(0,999)), 'data' => date('d.m.Y'), 'type'=> 'only | recursive', 'access'=> 'Read', 'remove'=>'Add'],
    );

    $site   =   url::site(). '/' .$start;

    $aaa    =   <<<AAA
pavel@karasev.ru:
    access:  [ Read, Edit ]
    subproject:  Yes
    comment:  lksdfsdf sdvdsv

public:
    subproject:  No

0800fc577294c34e0b28ad2839435945:
    access:  [ Read ]
    subproject:  No
    comment:  ссылка для кого-то


AAA;
    ?>
    
    <div class="access" style="display: none;">
        <table>
            <?
            foreach( $table as $v )
            {
                ?>
                <tr>
                    <!-- <td><?= $v['project'] ?></td> -->
                    <td><?= $v['target'] ?></td>
                    <td><?= $v['data'] ?></td>
                    <td><?= $v['type'] ?></td>
                    <td><?= $v['access'] ?></td>
                    <td><?= $v['remove'] ?></td>
                </tr>
                <?
            }
            ?>
        </table>
        <br />
        <button class="save">Сохранить</button>
        
    </div>

    <form class="tree" method="post">
        <textarea class="ace" name="access" data-mode="ace/mode/yaml"><?= $aaa ?></textarea>
        <div class="submit">
            <a href="">Добавить ссылку доступа</a>
            <button class="save">Сохранить</button>
        </div>
    </form>

    <?
    echo '<script src="' .load::makefile('/t/ace/ace.js', 'inc/ace/ace.js', true, false). '"></script>';
    echo '<script src="' .load::makefile('/t/ace/mode-yaml.js', 'inc/ace/mode-yaml.js', true, false). '"></script>';
    // echo '<script src="' .load::makefile('/t/ace/theme-tomorrow_night.min.js', 'inc/ace/theme-tomorrow_night.min.js', true, false). '"></script>';
    echo '<script src="' .load::makefile('/t/_page.js', '_page.js'). '"></script>';
    
}

?>
