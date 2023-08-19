
<form class="tree" method="post">
    <textarea class="ace" name="line" data-mode="ace/mode/html"><?= line::asText() ?></textarea>
    <div class="submit">
        <div></div>
        <button class="save" id="btn-save">Сохранить</button>
    </div>
</form>

<script src="<?= load::makefile('/t/ace/ace.js', '../../_lib/inc/ace/ace.js') ?>"></script>
<script src="<?= load::makefile('/t/ace/mode-html.js', '../../_lib/inc/ace/mode-html.js') ?>"></script>
<script src="<?= load::makefile('/t/ace/emmet.js', '../../_lib/inc/ace/emmet.js') ?>"></script>
<script src="<?= load::makefile('/t/ace/ext-emmet.js', '../../_lib/inc/ace/ext-emmet.js') ?>"></script>

<script src="<?= load::makefile('/t/_page.js', '../ui/pack/pack.js') ?>"></script>
