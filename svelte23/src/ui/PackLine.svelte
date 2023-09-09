<script>
// @ts-nocheck
import { pack, lineText, lineHtml, api, href } from "../state/store";
import AceHtml from "./ace/AceHtml.svelte";


function save()
{
    api({pack: $pack.start, line: $lineText, wait: ["lineHtml"]}, (res)=>{
        lineHtml.set(res.lineHtml)
        href(`/${$pack.start}`)
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

{#if $lineText !== false} <AceHtml bind:value={$lineText} />
{/if}

<br>
<button id="ctrl-s" on:click={save}>Сохранить</button>