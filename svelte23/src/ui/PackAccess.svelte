<script>
// @ts-nocheck
import { pref, packBc, packStart, accessText } from "../state/store";
import AceEditor from "./comp/AceEditor.svelte";


let cssSave  =   "";


function save()
{
    pref(`/${$packStart}/access`, {access: $accessText, wait:['accessText']});
    cssSave = "active"
    setTimeout(()=>cssSave="", 500)
}


document.onkeydown = (e) => {
    if ( ['KeyS', 'Enter'].includes(e.code)  &&  (e.ctrlKey || e.metaKey) )
    {
        e.preventDefault()
        save()
    }
}
</script>


{#if $packStart} <AceEditor bind:value={$accessText} mode="yaml" /> {/if}

<br />
<button id="ctrl-s" class="{cssSave}" on:click={save}>Сохранить</button>
