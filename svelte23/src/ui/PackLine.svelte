<script>
// @ts-nocheck
import { lineText, pack1, pack} from "../state/store";
import AceHtml from "./ace/AceHtml.svelte";


function save()
{
    // alert("get save")
}


document.onkeydown = (e) => {
    if ( ['KeyS', 'Enter'].includes(e.code)  &&  (e.ctrlKey || e.metaKey) )
    {
        e.preventDefault()
        save()
        pack1(`/${$pack.start}`)
    }
}
</script>

<AceHtml bind:value={$lineText} />

<br>
<button id="ctrl-s" on:click={save}>Сохранить</button>