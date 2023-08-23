<script>
  // @ts-nocheck
  import { url, href } from "./state/url";
  import Main from "./ui/Main.svelte";
  import Pack from "./ui/Pack.svelte";
</script>

<h3>Default: 
  <button on:click={()=> href("/")  }>Main</button>
  <button on:click={()=> href("/1") }>Pack</button>
</h3>

{#if $url.path == '/'     }   <Main />
{:else if +$url.level[0]  }   <Pack />
{/if}
 