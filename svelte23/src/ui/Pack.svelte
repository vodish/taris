<script>
// @ts-nocheck
import PackLine         from "./PackLine.svelte";
import PackView         from "./PackView.svelte";
import PackTree         from "./PackTree.svelte";
import PackAccess       from "./PackAccess.svelte";
import PackLog          from "./PackLog.svelte";
import MenuItem         from "./comp/MenuItem.svelte";
import { url, href, pref, isProject, packBc, packTitle, packTree, packMenu }    from "../state/store";


$: level1   =   $url.level[1] || "view";
$: profile  =   $packBc[0] ?  $packBc[0].name : '';


</script>


<svelte:head><title>{$packTitle}</title></svelte:head>

<div class="nav1">
    <div class="bc">
        <a href="/" class="logo" on:click={href}>Taris</a>
        {#each $packBc as pack }
            <i class="{pack._pub} {pack._cur}"></i>
            <a  href="/{pack.id}" on:click={pref} class="{pack._cur}">{pack.name}</a>
        {/each}

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
                        {#if pack.id }
                            <a  href={"/" + pack.id}
                                on:click={pref}
                                class="{pack._prj} {pack._act}{!pack.id? 'empty': ''}"
                                style="padding-left: {pack.space/2}ch;"
                                >{pack.name}</a>
                        {:else}
                            <div class="empty"></div>
                        {/if}

                    {/each}
                </div>
            </div>
        </div>
    </div>

    
    <div class="burger">
        <div class="name">{$packMenu.name}</div>
        {#if 'view' in $packMenu }
            <div class="menu">
                <MenuItem key="view" href="/{$url.level[0]}" />
                <MenuItem key="line" href="/{$url.level[0]}/line" />
                
                {#if 'tree' in $packMenu }
                <div class="group1">
                    <MenuItem key="tree" href="/{$url.level[0]}/tree" />
                    {#if $isProject===false} <a href="/{$url.level[0]}/treeAdd" on:click={pref} class="a icon" title="Выделить проект">+</a> {/if}
                    {#if $isProject===true} <a href="/{$url.level[0]}/treeDel" on:click={pref} class="a icon" title="Отменить проект">-</a> {/if}
                </div>
                {/if}

                {#if 'access' in $packMenu }
                <div class="group1">
                    <MenuItem key="access" href="/{$url.level[0]}/access" />
                    <a href="/{$url.level[0]}/accessLink" on:click={pref} class="a icon" title="Поделится ссылкой">{@html '&#9741;'}</a>
                </div>
                {/if}
                
                <MenuItem key="log" href="/{$url.level[0]}/log" />
                <MenuItem key="bye" href="/bye/{profile}" />
            </div>
        {/if}
    </div>

</div>


{#if        level1 == "view"    }   <PackView />
{:else if   level1 == "line"    }   <PackLine />
{:else if   level1 == "tree"    }   <PackTree />
{:else if   level1 == "access"  }   <PackAccess />
{:else if   level1 == "log"     }   <PackLog />
{/if}
