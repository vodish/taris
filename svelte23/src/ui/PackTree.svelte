<script>
// @ts-nocheck
import { packStart, packTitle, packBc, packTree, treeText, api, href } from "../state/store";
import AceYaml from './comp/AceYaml.svelte';




function save()
{
    api({pack: $packStart, tree: $treeText, wait: ["packStart", "packTitle", "packBc", "packTree"]},
        (res)=>{
            packStart.set(res.packStart)
            packTitle.set(res.packTitle)
            packBc.set(res.packBc)
            packTree.set(res.packTree)
            href(`/${$packStart}`)
        }
    )
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
