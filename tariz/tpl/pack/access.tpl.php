<?
# крошки проекта
#
$bc =  array_reverse($pack->bc);
#
#
access::$pack   =&  $pack;
access::actionSave();
access::actionCreateLink();


// load::vd(access::$list);

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
        
        echo access::asHtml($packId);
    }
    ?>
    
</div>


<form action="<?= url::$dir[1] ?>" class="tree access" method="post">
    <textarea class="ace" name="access" data-mode="ace/mode/yaml" data-minLines="5" data-showGutter="false"><?= access::asText($pack->project) ?></textarea>
    <div class="submit">
        <div></div>
        <button class="save" id="btn-save">Сохранить</button>
    </div>
</form>

<script src="<?= load::makefile('/t/ace/ace.js', 'inc/ace/ace.js', true, false) ?>"></script>
<script src="<?= load::makefile('/t/ace/mode-yaml.js', 'inc/ace/mode-yaml.js', true, false) ?>"></script>

<script src="<?= load::makefile('/t/_page.js', '_page.js') ?>"></script>
