<?php


load::vd($access);
load::vd($user);

?>


<form action="<?= url::$dir[1] ?>" class="tree" method="post">
    <textarea class="ace" name="access" data-mode="ace/mode/yaml"><?= $project->access_yaml ?></textarea>
    <div class="submit">
        <a href="<?= url::$dir[1]. '?createAccessLink' ?>">Добавить ссылку доступа</a>
        <button class="save" id="btn-save">Сохранить</button>
    </div>
</form>

<script src="<?= load::makefile('/t/ace/ace.js', 'inc/ace/ace.js', true, false) ?>"></script>
<script src="<?= load::makefile('/t/ace/mode-yaml.js', 'inc/ace/mode-yaml.js', true, false) ?>"></script>

<script src="<?= load::makefile('/t/_page.js', '_page.js') ?>"></script>
