<script>
  // @ts-nocheck
  import { url, href } from "./state/url";
  import Main from "./ui/Main.svelte";
  import Pack from "./ui/Pack.svelte";
</script>


{#if $url.path == '/'     }   <Main />
{:else if +$url.level[0]  }   <Pack />
{/if}
 