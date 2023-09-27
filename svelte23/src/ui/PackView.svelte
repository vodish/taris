<script>
// @ts-nocheck
import { hpack, packStart, treePack, packHeap, lineHtml } from "../state/store";


document.onkeydown = (e) => {
    
    if ( ['KeyS', 'Enter'].includes(e.code)  &&  (e.ctrlKey || e.metaKey) )
    {
        e.preventDefault()

        hpack(`/${$packStart}/line`)
    }
}



</script>


<div class="pro">
    <div class="tree">
        {#each $treePack as v }
            <div class="name {v.project? 'project': ''} {v.id == $packStart? 'active': ''}" style="margin-left: {v.level * 20}px;">
                
                <a href={"/" + v.id} on:click={hpack}>{$packHeap[v.id].name}</a>
            </div>
        {/each}
    </div>
    <div class="file">
        {@html $lineHtml }
    </div>
</div>
