<script>
// @ts-nocheck
import { url, href, api }    from "../state/url";
import PackLine         from "./PackLine.svelte";
import PackView         from "./PackView.svelte";
import PackTree         from "./PackTree.svelte";
import PackAccess       from "./PackAccess.svelte";
import { packId, packBc, packTitle, packTree, packView }       from "../state/store";
    

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




</script>

<svelte:head><title>{$packTitle}</title></svelte:head>

<div class="nav1">
    <div class="bc">
        <a href="/" class="logo" on:click={href}>Taris</a>

        {#if $packBc}
            {#each $packBc as v }
                <a href={"/" + v.id} on:click={href}>{v.name}</a>            
            {/each}
        {/if}

    </div>

    <div class="opt">
        <i class="save" id="saved">Saved</i>
        
        <span>-&nbsp;Проект</span>
        <span>+&nbsp;Проект</span>

        <i class="sep"></i>
        <a href="/1" on:click={href}>Просмотр</a>
        <a href="/1/line" on:click={href} class="b">Записи</a>
        <a href="/1/tree" on:click={href}>Дерево</a>
        <a href="/1/access" on:click={href}>Доступ</a>
    </div>
</div>



{#if $url.level[1] == undefined     }   <PackView />
{:else if $url.level[1] == "line"   }   <PackLine />
{:else if $url.level[1] == "tree"   }   <PackTree />
{:else if $url.level[1] == "access" }   <PackAccess />
{/if}
