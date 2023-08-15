<style>
.access2    .pack   { display: flex; justify-content: space-between; margin: 1em 0 0.5ch 0; padding-bottom: 0.3em; border-bottom: solid 1px #ccc; }
.access2    .pack .name   { margin-right: 2ch; }
.access2    .pack .opts   { display: flex; }
.access2    .pack .opts > *   { margin: 0 0.7ch; }
.access2    pre     { margin-left: 4ch; white-space: pre-wrap; font-family: var(--font1); font-size: 13px; line-height: 1.4em;; }

form.access     { margin: 0 0 0 3ch; width: inherit; box-sizing: border-box; }
</style>


<?php

# крошки проекта
#
$bc =  array_reverse($pack->bc);


?>


<div class="access2">
    <?
    foreach( $bc as $k => $packId )
    {
        $name   =   $pack->list[ $packId ]['name'];
        ?>
        <div class="pack">
            <?= $packId != $pack->project?  '<a class="name z" href="/' .$packId. '/access">' .$name. '</a>' :  '<div class="name">' .$name. '</div>' ?>
            
            <?
            if ( $packId == $pack->project )
            {
                ?>
                <div class="opts">
                    <!-- <a href="<?= url::$dir[1]. '?action=add&role=Admin' ?>">+&nbsp;Админ</a>
                    <a href="<?= url::$dir[1]. '?action=add&role=Edit' ?>">+&nbsp;Редактор</a>
                    <a href="<?= url::$dir[1]. '?action=add&role=View' ?>">+&nbsp;Просмотр</a> -->
                    <a href="<?= url::$dir[1]. '?action=add&role=View&type=Hash' ?>">+&nbsp;Ссылка</a>
                </div>
                <?
            }
            ?>
        </div>
        <?

        if ( !($list =  $access[ $packId ] ?? null) )   continue;   # нет записей
        if ( $packId == $pack->project )                continue;   # текущий проект
        
        foreach( $list as $v )
        {
            echo '<pre>' .$v['email']. ':</pre>';
            echo '<pre>    role: "' .$v['role']. '"</pre>';
            echo $v['comment'] ? '<pre>    ' .$v['comment']. '</pre>': '';
            echo '<br />';
        }
    }
    ?>
    
</div>



<form action="<?= url::$dir[1] ?>" class="tree access" method="post">
    <textarea class="ace" name="access" data-mode="ace/mode/yaml" data-minLines="5" data-showGutter="false"></textarea>
    <div class="submit">
        <button class="save" id="btn-save">Сохранить</button>
    </div>
</form>

<script src="<?= load::makefile('/t/ace/ace.js', 'inc/ace/ace.js', true, false) ?>"></script>
<script src="<?= load::makefile('/t/ace/mode-yaml.js', 'inc/ace/mode-yaml.js', true, false) ?>"></script>

<script src="<?= load::makefile('/t/_page.js', '_page.js') ?>"></script>
