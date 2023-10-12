<script>
// @ts-nocheck
import { url, pref, packMenu } from "../../state/store";

export let key;
export let href;

$: level1  =   $url.level[1] || "view";

</script>


{#if key in $packMenu }
    {#if level1 == key }  <span class="a {key}">{$packMenu[key]}</span>
    {:else}  <a {href} on:click={pref} class="{key}">{@html $packMenu[key]}</a>
    {/if}
{/if}
