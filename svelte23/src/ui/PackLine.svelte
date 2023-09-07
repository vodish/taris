<script>
// @ts-nocheck
import { lineText, pack } from "../state/store";
import AceHtml from "./ace/AceHtml.svelte";


function save()
{
    api({pack: $pack.start, line: $lineText}, (res)=>{
        pack1(`/${$pack.start}`)
    })
}


document.onkeydown = (e) => {
    if ( ['KeyS', 'Enter'].includes(e.code)  &&  (e.ctrlKey || e.metaKey) )
    {
        e.preventDefault()
        save()
    }
}
</script>

<AceHtml bind:value={$lineText} />

<br>
<button id="ctrl-s" on:click={save}>Сохранить</button>