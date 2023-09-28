<script>
// @ts-nocheck
import { packStart, treeText, api, href } from "../state/store";
import AceYaml from './ace/AceYaml.svelte';




function save()
{
    api({pack: $packStart, tree: $treeText, wait: ["packStart", "treePack"]}, (res)=>{
        // pack.set(res.pack)
        packStart.set(res.packStart)
        pactreePack.set(res.treePack)
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
