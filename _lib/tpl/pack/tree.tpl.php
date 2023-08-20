<?
# сохранить дерево проекта
#
project::actionSave();

?>

<form class="tree" method="post">
    <textarea class="ace" name="tree" data-mode="ace/mode/yaml"><?= trim(project::asText( project::$id )) ?></textarea>
    <div class="submit">
        <div></div>
        <button class="save" id="btn-save">Сохранить</button>
    </div>
</form>

<script src="<?= ui::makefile('/t/ace/ace.js', 'inc/ace/ace.js', true, false) ?>"></script>
<script src="<?= ui::makefile('/t/ace/mode-yaml.js', 'inc/ace/mode-yaml.js', true, false) ?>"></script>
<? // echo '<script src="' .ui::makefile('/t/ace/theme-tomorrow_night.min.js', 'inc/ace/theme-tomorrow_night.min.js', true, false). '"></script>'. "\n"; ?>

<script src="<?= ui::makefile('/t/_page.js', '_page.js') ?>"></script>
