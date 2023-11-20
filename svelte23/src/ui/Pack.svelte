<script>
// @ts-nocheck
import PackLine         from "./PackLine.svelte";
import PackView         from "./PackView.svelte";
import PackTree         from "./PackTree.svelte";
import PackAccess       from "./PackAccess.svelte";
import PackLog          from "./PackLog.svelte";
import MenuItem         from "./comp/MenuItem.svelte";
import { url, href, pref, isProject, packBc, packTitle, packTree, packMenu }    from "../state/store";


$: level1       =   $url.level[1] || "";
$: level1       =   { [level1]:"view", line:"line", tree:"tree", access:"access", log:"log" }[ level1 ];

$: profile      =   $packBc[0] ?  $packBc[0].name : '';
$: menuEmpty    =   Object.keys($packMenu).length < 2 ? "empty": "";
$: name         =   $packBc[0] ?  $packBc[ $packBc.length -1 ]:  '';


function share(e)
{
    pref( e, {}, (res)=>navigator.clipboard.writeText(`https://taris.pro${res.href}`) )
}

</script>


<svelte:head><title>{$packTitle}</title></svelte:head>

<div class="nav1">
    <div class="bc">
        <a href="/" class="logo" on:click={href}>Taris</a>
        {#each $packBc as pack }
            <i class="sep {pack._pub} {pack._cur}"></i>
            <a  href="/{pack.id}" on:click={pref} class="{pack._cur}">{pack.name}</a>
        {/each}
    </div>


    <div class="bcm">
        <i class="sep {name._cur} {name._pub}"></i>
        <span class="name">{name.name || ''}</span>
        
        <div class="menu">
            <div class="wrap">
                <div class="bc2">
                    <a href="/" class="logo" on:click={href}>Taris</a>
                    {#each $packBc as pack }
                        <a  href="/{pack.id}" on:click={pref} class="{pack._cur} {pack._pub} nav">{pack.name}</a>
                    {/each}
                </div>
                <div class="tree2">
                    {#each $packTree as pack }
                        {#if pack.id }  <a  href={"/" + pack.id} on:click={pref} class="{pack._prj} {pack._act}{!pack.id? 'empty': ''}" style="padding-left: {pack.space/2}ch;">{pack.name}</a>
                        {:else}         <div class="empty"></div>
                        {/if}
                    {/each}
                </div>
            </div>
        </div>
    </div>

    
    <div class="burger">
        <div class="name {menuEmpty}">{$packMenu.name}</div>
        <div class="menu {menuEmpty}">

            {#if 'view' in $packMenu }
            <div class="group1">
                <MenuItem key="view" href="/{$url.level[0]}" />
                <a href="/{$url.level[0]}/accessLink" on:click={share} class="a icon" title="Поделиться ссылкой">{@html '&#9741;'}</a>
            </div>
            {/if}
            
            <MenuItem key="line" href="/{$url.level[0]}/line" />
            
            {#if 'tree' in $packMenu }
            <div class="group1">
                <MenuItem key="tree" href="/{$url.level[0]}/tree" />
                {#if $isProject===false} <a href="/{$url.level[0]}/treeAdd" on:click={pref} class="a icon" title="Выделить проект">+</a> {/if}
                {#if $isProject===true} <a href="/{$url.level[0]}/treeDel" on:click={pref} class="a icon" title="Отменить проект">-</a> {/if}
            </div>
            {/if}

            <MenuItem key="access" href="/{$url.level[0]}/access" />
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
