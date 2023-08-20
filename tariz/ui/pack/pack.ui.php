<?
$start  =   pack::$start;
?>

<div class="nav1">
    <div class="bc">
        <a href="/" class="logo"><b>T</b>ari<b>Z</b></a>
        <?
        $bc =   array_reverse(pack::$bc);

        foreach( $bc as $v )
        {
            $v  =   pack::$list[ $v ];
            ?>
            <i>/</i>
            <a href="/<?= $v['id'] ?>" class="<?= $v['id']==project::$id && !isset(url::$level[1]) ? 'active': '' ?>"><?= $v['name'] ?></a>
            <?
        }

        if ( $start != project::$id ) {
            echo '<i>/</i>';
            echo '<a href="/' .$start. '" class="current z">' .pack::$list[$start]['name']. '</a>';
        }
        ?>
    </div>
    
    <div class="opt">
        <?
        # отчет по операции
        if ( isset($_SESSION['save']) ) { unset($_SESSION['save']); echo '<i class="save" id="saved">Saved</i>'; }
        ?>
        
        <a href="<?= url::$dir[0]. (@url::$level[1]!='line' ? '/line': '') ?>" class="<?= @url::$level[1]=='line'? 'active': '' ?> b" id="edit">Записи</a>
        <?= $start == project::$id  && isset(pack::$bc[1]) && !isset(url::$level[1])  ? '<a href="' .url::$dir[0].     '?actionProjectCansel">-&nbsp;Проект</a>' : '' ?>
        <?= $start != project::$id && !isset(url::$level[1]) ? '<a href="' .url::$dir[0]. '?actionProjectCreate">+&nbsp;Проект</a>' : '' ?>
        
        <i class="sep"></i>
        <a href="<?= url::$dir[0]. (@url::$level[1]!='tree' ? '/tree': '') ?>" class="<?= @url::$level[1]=='tree'? 'active': '' ?>">Дерево</a>
        <a href="<?= url::$dir[0]. (@url::$level[1]!='access' ? '/access': '') ?>" class="<?= @url::$level[1]=='access'? 'active': '' ?>">Доступ</a>
        
    </div>
</div>

<?
# обзор проекта
# редактирование дерева проекта
# редактирование файла
# ностройка прав пачки
#
ui::include('../ui/pack/view.ui.php');
ui::include('../ui/pack/line.ui.php');
ui::include('../ui/pack/tree.ui.php');
ui::include('../ui/pack/access.ui.php');