<script>
// @ts-nocheck
import { packStart, lineText, lineHtml, api, href } from "../state/store";
import AceHtml from "./ace/AceHtml.svelte";


function save()
{
    api({pack: $packStart, line: $lineText, wait: ["lineHtml"]}, (res)=>{
        lineHtml.set(res.lineHtml)
        href(`/${$packStart}`)
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

{#if $packStart} <AceHtml bind:value={$lineText} /> {/if}

<br>
<button id="ctrl-s" on:click={save}>Сохранить</button>