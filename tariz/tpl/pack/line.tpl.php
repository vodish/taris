<form class="tree" method="post">
    <textarea class="ace" name="line" data-mode="ace/mode/html"><?= $line->asText() ?></textarea>
    <div class="submit">
        <div></div>
        <button class="save" id="btn-save">Сохранить</button>
    </div>
</form>

<script src="<?= load::makefile('/t/ace/ace.js', 'inc/ace/ace.js', true, false) ?>"></script>
<script src="<?= load::makefile('/t/ace/mode-html.js', 'inc/ace/mode-html.js', true, false) ?>"></script>
<script src="<?= load::makefile('/t/ace/emmet.js', 'inc/ace/emmet.js', true, false) ?>"></script>
<script src="<?= load::makefile('/t/ace/ext-emmet.js', 'inc/ace/ext-emmet.js', true, false) ?>"></script>

<script src="<?= load::makefile('/t/_page.js', '_page.js') ?>"></script>
