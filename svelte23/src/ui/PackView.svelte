<script>
// @ts-nocheck

import { packTree, packView } from "../state/store";
import { url, href } from "../state/url";


function handleApi(e)
{
    e.preventDefault()
    href(e)
    console.log( $url.level[0] )
    
}

</script>

<div class="pro">
    <div class="tree">
        {#each $packTree as v }
            <div class="name"><a href={"/" + v.id} on:click={handleApi}>{v.name}</a></div>          
        {/each}
    </div>
    <div class="file">
        {@html $packView }
    </div>
</div>
