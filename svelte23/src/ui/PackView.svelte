<script>
// @ts-nocheck
import { hpack, packStart, packTree, lineHtml } from "../state/store";


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
        
        {#each $packTree as pack }
            <div class="name {pack._act}" style="margin-left: {pack.space/2}ch;">
                <a href={"/" + pack.id} on:click={hpack} class="{pack._prj}">{pack.name}</a>
            </div>
        {/each}
        
    </div>
    <div class="file">
        {@html $lineHtml }
    </div>
</div>
