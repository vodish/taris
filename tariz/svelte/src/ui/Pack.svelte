<script>
    import { uiPack }   from "../state/ui";
    import PackLine     from "./PackLine.svelte";
    import PackView     from "./PackView.svelte";
    import PackTree     from "./PackTree.svelte";
    import PackAccess   from "./PackAccess.svelte";
</script>
<hr>
<h4>
    Pack: 
    <button on:click={()=> $uiPack = ["View"] }>View</button>
    <button on:click={()=> $uiPack = ["Line"] }>Line</button>
    <button on:click={()=> $uiPack = ["Tree"] }>Tree</button>
    <button on:click={()=> $uiPack = ["Access"] }>Access</button>
</h4>

{#if $uiPack.includes("View") } <PackView /> {/if}
{#if $uiPack.includes("Line") } <PackLine /> {/if}
{#if $uiPack.includes("Tree") } <PackTree /> {/if}
{#if $uiPack.includes("Access") } <PackAccess /> {/if}