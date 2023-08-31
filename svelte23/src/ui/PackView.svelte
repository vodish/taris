<script>
// @ts-nocheck

import { packId, packBc, packTitle, packTree, packView } from "../state/store";
import { url, href, api } from "../state/url";


function handleApi(e)
{
    e.preventDefault()
    href(e)
    
    api({
        pack: $url.level[0],
        packId:1,
        packTitle:1,
        packBc:1,
        packTree:1,
        packView:1,
        },
        (res) => {
            packId.set(res.packId)
            packTitle.set(res.packTitle)
            packBc.set(res.packBc)
            packTree.set(res.packTree)
            packView.set(res.packView)
        }
    )

    
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
