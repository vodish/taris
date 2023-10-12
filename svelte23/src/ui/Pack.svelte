<script>
// @ts-nocheck
import PackLine         from "./PackLine.svelte";
import PackView         from "./PackView.svelte";
import PackTree         from "./PackTree.svelte";
import PackAccess       from "./PackAccess.svelte";
import PackLog          from "./PackLog.svelte";
import MenuItem         from "./comp/MenuItem.svelte";
import { url, href, pref, packBc, packTitle, packMenu }    from "../state/store";


$: level1  =   $url.level[1] || "view";
</script>




<svelte:head><title>{$packTitle}</title></svelte:head>

<div class="nav1">
    <div class="bc">
        <a href="/" class="logo" on:click={href}>Taris</a>
        {#each $packBc as pack }
            <i></i>
            <a  href={"/" + pack.id} on:click={pref} class="{pack._act} {pack._cur}">{pack.name}</a>
        {/each}
    </div>

    <div class="burger" >
        <div class="name">{$packMenu.name}</div>
        <div class="menu">
            <MenuItem key="view" href="/{$url.level[0]}" />
            <MenuItem key="line" href="/{$url.level[0]}/line" />
            <div class="group1">
                <MenuItem key="tree" href="/{$url.level[0]}/tree" />
                <MenuItem key="treeAdd" href="/{$url.level[0]}/treeAdd" />
                <MenuItem key="treeDel" href="/{$url.level[0]}/treeDel" />
            </div>
            <MenuItem key="access" href="/{$url.level[0]}/access" />
            <MenuItem key="log" href="/{$url.level[0]}/log" />
        </div>
    </div>
</div>


{#if        level1 == "view"    }   <PackView />
{:else if   level1 == "line"    }   <PackLine />
{:else if   level1 == "tree"    }   <PackTree />
{:else if   level1 == "access"  }   <PackAccess />
{:else if   level1 == "log"     }   <PackLog />
{/if}
