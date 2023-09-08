<script>
// @ts-nocheck
import PackLine         from "./PackLine.svelte";
import PackView         from "./PackView.svelte";
import PackTree         from "./PackTree.svelte";
import PackAccess       from "./PackAccess.svelte";
import { url, get, href, hpack, pack }    from "../state/store";
    




</script>

<svelte:head><title>{$pack.title}</title></svelte:head>

<div class="nav1">
    <div class="bc">
        <a href="/" class="logo" on:click={href}>Taris</a>

        {#each $pack.bc as id }
            <i>/</i>
            <a href={"/" + id} on:click={hpack} class="{$pack.project==id? 'active': ''} {$pack.start==id && $pack.project!=id? 'current': ''}">
                {$pack.heap[id].name}
            </a>
        {/each}

    </div>

    <div class="opt">
        <!-- <i class="save" id="saved">Saved</i>
        <span>-&nbsp;Проект</span>
        <span>+&nbsp;Проект</span> -->

        <i class="sep"></i>
        <a href="/{$pack.start}/line" on:click={hpack} class="b">Записи</a>
        <a href="/{$pack.start}/tree" on:click={hpack}>Дерево</a>
        <a href="/{$pack.start}/access" on:click={hpack}>Доступ</a>
    </div>
</div>



{#if        ! $url.level[1]             }   <PackView />
{:else if   $url.level[1] == "line"     }   <PackLine />
{:else if   $url.level[1] == "tree"     }   <PackTree />
{:else if   $url.level[1] == "access"   }   <PackAccess />
{/if}
