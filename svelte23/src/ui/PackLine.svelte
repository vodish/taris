<script>
// @ts-nocheck
import { packStart, packMenu, lineText, lineMode, lineHtml, api, href }   from "../state/store";
import AceEditor from "./comp/AceEditor.svelte";
import { upload }   from "../state/attach";





// обработчик вставки скриншота
document.onpaste    =   upload



// сохранить текст файла

function save()
{
    api({pack: $packStart, line: $lineText, wait: ["lineHtml", "packMenu"]}, (res)=>{
        lineHtml.set(res.lineHtml)
        packMenu.set(res.packMenu)
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


{#if $packStart} <AceEditor bind:value={$lineText} mode={$lineMode} scrollKey={`${$packStart}/line/scrollY`} /> {/if}

<br>
<button id="ctrl-s" on:click={save}>Сохранить</button>