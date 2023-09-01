<script>
// @ts-nocheck
import { pack, pack1, lineHtml } from "../state/store";

</script>

<div class="pro">
    <div class="tree">
        {#each $pack.tree as v }
            <div class="name" style="margin-left: {v.level * 20}px;"><a href={"/" + v.id} on:click={pack1}>{$pack.heap[v.id].name}</a></div>
        {/each}
    </div>
    <div class="file">
        {@html $lineHtml}
    </div>
</div>
