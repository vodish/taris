<script>
    // @ts-nocheck
    import { pref, packStart, treeText } from "../state/store";
    import AceEditor from "./comp/AceEditor.svelte";


    function save()
    {
        pref(`/${$packStart}`, {tree: $treeText});
    }


    document.onkeydown = (e) => {
        if ( ['KeyS', 'Enter'].includes(e.code)  &&  (e.ctrlKey || e.metaKey) )
        {
            e.preventDefault()
            save()
        }
    }
</script>

{#if $packStart} <AceEditor bind:value={$treeText} mode="yaml"  scrollKey={`${$packStart}/tree/scrollY`} /> {/if}

<br />
<button id="ctrl-s" on:click={save}>Сохранить</button>
