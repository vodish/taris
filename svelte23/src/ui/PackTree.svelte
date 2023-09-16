<script>
// @ts-nocheck
import { pack, treeText, api, href } from "../state/store";
import AceYaml from './ace/AceYaml.svelte';




function save()
{
    api({pack: $pack.start, tree: $treeText, wait: ["pack"]}, (res)=>{
        pack.set(res.pack)
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

{#if $pack.start} <AceYaml bind:value={$treeText} /> {/if}

<br>
<button id="ctrl-s" on:click={save}>Сохранить</button>
