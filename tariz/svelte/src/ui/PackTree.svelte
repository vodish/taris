<script>
import { onMount } from 'svelte';
import { tree_content, ace_option } from '../state/pack';

import * as ace from "ace-builds";
import "ace-builds/src-noconflict/mode-html";
import "ace-builds/src-noconflict/ext-emmet";
import "emmet-core";


onMount(() => {
    const editor = ace.edit('ace9')
    editor.session.setMode('ace/mode/html')
    editor.setOptions(ace_option)
    editor.setValue($tree_content, 1)
    editor.on('change', () => $tree_content = editor.getValue())
});
</script>

<div id="ace9" class="ace" />
