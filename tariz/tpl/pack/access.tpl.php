<?php

// load::vd($access);
// load::vd($user);
function oper1($v)
{
    $arr = ['Owner'=>'is_owner', 'Admin'=>'is_admin', 'Edit'=>'is_edit', 'View'=>'is_view'];
    ?>
    <div class="oper1">
        <?
        foreach( $arr  as $name => $field )
        {
            echo '<div class="'. $field. ($v[$field]? ' active': ''). '">' .$name. '</div>';
        }
        ?>
    </div>
    <?
}
?>

<style>
    .access1  table { width: 100%; border-collapse: collapse; margin-bottom: 3em; }
    .access1  table td  { border-left: solid 1px #ccc; padding: 5px; }
    .access1 .oper1 { display: flex; width: 200px; }
    .access1 .oper1 > div { flex-basis: 130px; border: solid 1px #ccc; text-align: center; }
    .access1 .oper1 > div.active { background-color: #ccc; }
</style>

<div class="access1">
    <table>
    <?
    $bc =  array_reverse($pack->bc);

    foreach( $bc as $packId )
    {
        $list   =   $access[ $packId ] ?? array();

        //if ( ! $list )  continue;

        echo '<tr><td colspan="6"><h3>' .$pack->list[ $packId ]['name']. '</h3></td></tr>';

        foreach($list as $v)
        {
            ?>
            <tr>
                <td><?= $v['email'] ? 'Email': '' ?><?= $v['hash'] ? 'Hash': '' ?></td>
                <td><?= $v['email'] ?><?= $v['hash'] ?></td>
                <td><? oper1($v) ?></td>
                <td><?= $v['is_recur'] ? 'Recursive': 'Single' ?></td>
                <td><?= $v['comment'] ?></td>
                <td><?= $v['updated'] ?></td>
            </tr>
            <?
        }
        
    }
    ?>
    </table>
</div>



<form action="<?= url::$dir[1] ?>" class="tree" method="post">
    <textarea class="ace" name="access" data-mode="ace/mode/yaml"></textarea>
    <div class="submit">
        <a href="<?= url::$dir[1]. '?createAccessLink' ?>">Добавить ссылку доступа</a>
        <button class="save" id="btn-save">Сохранить</button>
    </div>
</form>

<script src="<?= load::makefile('/t/ace/ace.js', 'inc/ace/ace.js', true, false) ?>"></script>
<script src="<?= load::makefile('/t/ace/mode-yaml.js', 'inc/ace/mode-yaml.js', true, false) ?>"></script>

<script src="<?= load::makefile('/t/_page.js', '_page.js') ?>"></script>
