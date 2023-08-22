
<form class="tree" method="post">
    <textarea class="ace" name="line" data-mode="ace/mode/html"><?= line::asText() ?></textarea>
    <div class="submit">
        <div></div>
        <button class="save" id="btn-save">Сохранить</button>
    </div>
</form>

<script src="<?= ui::makefile('/t/ace/ace.js', '../lib/inc/ace/ace.js') ?>"></script>
<script src="<?= ui::makefile('/t/ace/mode-html.js', '../lib/inc/ace/mode-html.js') ?>"></script>
<script src="<?= ui::makefile('/t/ace/emmet.js', '../lib/inc/ace/emmet.js') ?>"></script>
<script src="<?= ui::makefile('/t/ace/ext-emmet.js', '../lib/inc/ace/ext-emmet.js') ?>"></script>

<script src="<?= ui::makefile('/t/pack.js', '../ui/pack/pack.js') ?>"></script>
