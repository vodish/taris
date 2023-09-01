<script>
// @ts-nocheck
import { url, href, api }    from "../state/url";
import PackLine         from "./PackLine.svelte";
import PackView         from "./PackView.svelte";
import PackTree         from "./PackTree.svelte";
import PackAccess       from "./PackAccess.svelte";
import { view, pack, pack1 }       from "../state/store";
    


pack1($url.path)



</script>

<svelte:head><title>{$pack.title}</title></svelte:head>

<div class="nav1">
    <div class="bc">
        <a href="/" class="logo" on:click={href}>Taris</a>

        {#each $pack.bc as id }
            <i>/</i>
            <a href={"/" + id} on:click={pack1} class="{$pack.project==id? 'active': ''} {$pack.start==id && $pack.project!=id? 'current': ''}">
                {$pack.heap[id].name}
            </a>
        {/each}

    </div>

    <div class="opt">
        <i class="save" id="saved">Saved</i>
        
        <span>-&nbsp;Проект</span>
        <span>+&nbsp;Проект</span>

        <i class="sep"></i>
        <a href="/{$pack.start}/line" on:click={pack1} class="b" id="btn-line">Записи</a>
        <a href="/{$pack.start}/tree" on:click={pack1}>Дерево</a>
        <a href="/{$pack.start}/access" on:click={pack1}>Доступ</a>
    </div>
</div>



{#if        $view == 'html'     }   <PackView />
{:else if   $view == "line"     }   <PackLine />
{:else if   $view == "tree"     }   <PackTree />
{:else if   $view == "access"   }   <PackAccess />
{/if}
