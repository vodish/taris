<script>
import { ui, href } from "./state/store";

import Main from "./ui/Main.svelte";
import Pack from "./ui/Pack.svelte";


</script>

<a href="/" on:click={href}>Главная</a> .
<a href="/link" on:click={href}>Ссылка</a>


{#if $ui.includes('Main.svelte')     }    <Main />
{:else if $ui.includes('Pack.svelte')  }  <Pack />
{/if}
 