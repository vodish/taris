<script>
// @ts-nocheck
import PackLine         from "./PackLine.svelte";
import PackView         from "./PackView.svelte";
import PackTree         from "./PackTree.svelte";
import PackAccess       from "./PackAccess.svelte";
import { url, href, hpack, packStart, packBc, packHeap, packProject, packTitle }    from "../state/store";


function menu(e)
{
    console.log(e.target)
}

</script>


<svelte:head><title>{$packTitle}</title></svelte:head>

<div class="nav1">
    <div class="bc">
        <a href="/" class="logo" on:click={href}>Taris</a>

        {#each $packBc as id }
            <i>/</i>
            <a href={"/" + id} on:click={hpack} class="{$packProject==id? 'active': ''} {$packStart==id && $packProject!=id? 'current': ''}">
                {$packHeap[id].name}
            </a>
        {/each}

    </div>

    

    <div class="opt">
        <!-- <i class="save" id="saved">Saved</i> -->
        <!-- <i class="sep"></i> -->
    </div>

    
    <div class="burger" >
        <div class="name">Название</div>
        <div class="menu">
            <a href="/{$packStart}/line" on:click={hpack} class="b9 active">Записи</a>
            <a href="/{$packStart}/tree" on:click={hpack}>Дерево</a>
            <a href="/{$packStart}/access" on:click={hpack}>Доступ</a>

            <span>-&nbsp;Проект</span>
            <span>+&nbsp;Проект</span>
            
        </div>
    </div>
</div>



{#if        ! $url.level[1]             }   <PackView />
{:else if   $url.level[1] == "line"     }   <PackLine />
{:else if   $url.level[1] == "tree"     }   <PackTree />
{:else if   $url.level[1] == "access"   }   <PackAccess />
{/if}
