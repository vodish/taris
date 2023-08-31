<script>
// @ts-nocheck
import { url, href }  from "../state/url";
import PackLine       from "./PackLine.svelte";
import PackView       from "./PackView.svelte";
import PackTree       from "./PackTree.svelte";
import PackAccess     from "./PackAccess.svelte";

</script>


<div class="nav1">
    <div class="bc">
        <a href="/" class="logo" on:click={href}>Taris</a>
        Вывод крошек
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
