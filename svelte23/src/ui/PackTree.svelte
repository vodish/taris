<script>
    // @ts-nocheck
    import { pref, packStart, treeText } from "../state/store";
    import AceYaml from './comp/AceYaml.svelte';


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

{#if $packStart} <AceYaml bind:value={$treeText} /> {/if}

<br />
<button id="ctrl-s" on:click={save}>Сохранить</button>
