<script>
// @ts-nocheck
import { url, pref, packMenu } from "../../state/store";

export let key;
export let href;
export let cls = '';
export let title = '';

$: level1  =   $url.level[1] || "view";

</script>


{#if key in $packMenu }
    {#if level1 == key }  <span class="a {key} {cls}" {title}>{@html $packMenu[key]}</span>
    {:else}  <a {href} on:click={pref} class="a {cls}" {title}>{@html $packMenu[key]}</a>
    {/if}
{/if}
