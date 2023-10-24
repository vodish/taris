<script>
// @ts-nocheck
import PackLine         from "./PackLine.svelte";
import PackView         from "./PackView.svelte";
import PackTree         from "./PackTree.svelte";
import PackAccess       from "./PackAccess.svelte";
import PackLog          from "./PackLog.svelte";
import MenuItem         from "./comp/MenuItem.svelte";
import { url, href, pref, packBc, packTitle, packMenu }    from "../state/store";


$: level1   =   $url.level[1] || "view";
$: profile  =   $packBc[0] ?  $packBc[0].name : '';

</script>


<svelte:head><title>{$packTitle}</title></svelte:head>

<div class="nav1">
    <div class="bc">
        <a href="/" class="logo" on:click={href}>Taris</a>
        {#each $packBc as pack }
            <i></i>
            <a  href="/{pack.id}" on:click={pref} class="{pack._act} {pack._cur}">{pack.name}</a>
        {/each}
    </div>

    <div class="burger" >
        <div class="name">{$packMenu.name}</div>
        <div class="menu">
            <MenuItem key="view" href="/{$url.level[0]}" />
            <MenuItem key="line" href="/{$url.level[0]}/line" />
            <div class="group1">
                <MenuItem key="tree" href="/{$url.level[0]}/tree" />
                <MenuItem key="treeAdd" href="/{$url.level[0]}/treeAdd" cls="icon" title="Выделить проект" />
                <MenuItem key="treeDel" href="/{$url.level[0]}/treeDel" cls="icon" title="Отменить проект" />
            </div>
            {#if 'access' in $packMenu }
                <div class="group1">
                    <MenuItem key="access" href="/{$url.level[0]}/access" />
                    <a href="/{$url.level[0]}/access-link" on:click={pref} class="a icon" title="Доступ по ссылке">{@html '&#9741;'}</a>
                </div>
            {/if}
            <MenuItem key="log" href="/{$url.level[0]}/log" />
            <MenuItem key="bye" href="/bye/{profile}" />
        </div>
    </div>
</div>


{#if        level1 == "view"    }   <PackView />
{:else if   level1 == "line"    }   <PackLine />
{:else if   level1 == "tree"    }   <PackTree />
{:else if   level1 == "access"  }   <PackAccess />
{:else if   level1 == "log"     }   <PackLog />
{/if}
