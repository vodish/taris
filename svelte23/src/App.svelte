<script>
// @ts-nocheck
import { url } from "./state/store";

import Main from "./ui/Main.svelte";
// import Pack from "./ui/Pack.svelte";

</script>



{#if $url.path == "/"     }             <Main />
<!-- {:else if Number($url.level[0]) > 0  }  <Pack /> -->
{/if}
