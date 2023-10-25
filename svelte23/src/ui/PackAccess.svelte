<script>
    // @ts-nocheck
    import { pref, packBc, packStart, accessText } from "../state/store";
    import AceYaml from './comp/AceYaml.svelte';

    
    function save()
    {
        pref(`/${$packStart}/access`, {access: $accessText, wait:['accessText']});
    }


    document.onkeydown = (e) => {
        if ( ['KeyS', 'Enter'].includes(e.code)  &&  (e.ctrlKey || e.metaKey) )
        {
            e.preventDefault()
            save()
        }
    }
</script>


{#if $packStart} <AceYaml bind:value={$accessText} /> {/if}

<br />
<button id="ctrl-s" on:click={save}>Сохранить</button>