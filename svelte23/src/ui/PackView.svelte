<script>
// @ts-nocheck
import { pref, packStart, packMenu, packTree, lineHtml } from "../state/store";


document.onkeydown = (e) => {
    
    if ( $packMenu.line == undefined )  return

    if ( ['KeyS', 'Enter'].includes(e.code)  &&  (e.ctrlKey || e.metaKey) )
    {
        e.preventDefault()
        pref(`/${$packStart}/line`)
    }
    else if ( ['KeyX'].includes(e.code)  &&  (e.ctrlKey || e.metaKey) )
    {
        e.preventDefault()
        pref(`/${$packStart}/tree`)
    }
}

</script>


<div class="pro">
    <div class="tree">
        
        {#each $packTree as pack }
            <div class="{pack._act}{!pack.id? 'empty': ''}" style="margin-left: {pack.space/2}ch;">
                {#if pack.id }
                    <a href={"/" + pack.id} on:click={pref} class="{pack._prj}">{pack.name}</a>
                {/if}
            </div>
        {/each}
        
    </div>
    <div class="file">
        {@html $lineHtml }
    </div>
</div>
