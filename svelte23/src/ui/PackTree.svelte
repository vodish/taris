<script>
// @ts-nocheck
import { packStart, packTree, treeText, api, href } from "../state/store";
import AceYaml from './ace/AceYaml.svelte';




function save()
{
    api({pack: $packStart, tree: $treeText, wait: ["packStart", "packTree"]}, (res)=>{
        // pack.set(res.pack)
        packStart.set(res.packStart)
        packTree.set(res.packTree)
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

{#if $packStart} <AceYaml bind:value={$treeText} /> {/if}

<br />
<button id="ctrl-s" on:click={save}>Сохранить</button>
