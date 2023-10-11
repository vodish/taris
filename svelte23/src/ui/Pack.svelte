<script>
// @ts-nocheck
import PackLine         from "./PackLine.svelte";
import PackView         from "./PackView.svelte";
import PackTree         from "./PackTree.svelte";
import PackAccess       from "./PackAccess.svelte";
import PackLog          from "./PackLog.svelte";
import { url, href, pref, packStart, packProject, packBc, packTitle, packMenu }    from "../state/store";


// let ttt =  new URL("/aa/bb/?sdv=123", location)
// console.log(ttt)

</script>


<svelte:head><title>{$packTitle}</title></svelte:head>

<div class="nav1">
    <div class="bc">
        <a href="/" class="logo" on:click={href}>Taris</a>    
        {#each $packBc as pack }
            <i>/</i>
            <a  href={"/" + pack.id} on:click={pref} class="{pack._act} {pack._cur}">{pack.name}</a>
        {/each}
    </div>

    <div class="burger" >
        <div class="name">{$packMenu.name}</div>
        <div class="menu">
            {#if "view"     in $packMenu } <a href="/{$packStart}" on:click={pref}>{$packMenu.view}</a> {/if}
            {#if "line"     in $packMenu } <a href="/{$packStart}/line" on:click={pref}>{$packMenu.line}</a> {/if}
            {#if "tree"     in $packMenu } <a href="/{$packStart}/tree" on:click={pref}>{$packMenu.tree}</a> {/if}
            {#if "access"   in $packMenu } <a href="/{$packStart}/access" on:click={pref}>{$packMenu.access}</a> {/if}
            {#if "treeAdd"  in $packMenu } <a href="/{$packStart}/treeAdd" on:click={pref}>{$packMenu.treeAdd}</a> {/if}
            {#if "treeDel"  in $packMenu } <a href="/{$packStart}/treeDel" on:click={pref}>{$packMenu.treeDel}</a> {/if}
            {#if "log"      in $packMenu } <a href="/{$packStart}/log" on:click={pref}>{$packMenu.log}</a> {/if}
            
        </div>
    </div>
</div>


{#if        ! $url.level[1]             }   <PackView />
{:else if   $url.level[1] == "line"     }   <PackLine />
{:else if   $url.level[1] == "tree"     }   <PackTree />
{:else if   $url.level[1] == "access"   }   <PackAccess />
{:else if   $url.level[1] == "log"      }   <PackLog />
{/if}
