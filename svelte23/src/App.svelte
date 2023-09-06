<script>
// @ts-nocheck
import { ui } from "./state/store";

import Main from "./ui/Main.svelte";
import Pack from "./ui/Pack.svelte";

</script>


{#if $ui.includes('Main.svelte')     }    <Main />
{:else if $ui.includes('Pack.svelte')  }  <Pack />
{/if}
 