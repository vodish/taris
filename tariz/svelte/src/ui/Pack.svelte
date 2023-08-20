<script>
import { url, href }   from "../state/url";
import PackLine     from "./PackLine.svelte";
import PackView     from "./PackView.svelte";
import PackTree     from "./PackTree.svelte";
import PackAccess   from "./PackAccess.svelte";


</script>

<hr>
<h4>
    Pack: 
    <button on:click={()=> href("/1") }>View</button>
    <button on:click={()=> href("/1/line") }>Line</button>
    <button on:click={()=> href("/1/tree") }>Tree</button>
    <button on:click={()=> href("/1/access") }>Access</button>
</h4>

{#if !$url.level[1]} <PackView />
{:else if $url.level[1] == "line" } <PackLine />
{:else if $url.level[1] == "tree" } <PackTree />
{:else if $url.level[1] == "access" } <PackAccess />
{/if}
