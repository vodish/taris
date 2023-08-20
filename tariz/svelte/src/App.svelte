<script>
  import { uiDefault as ui } from "./state/ui";
  import Main from "./ui/Main.svelte";
  import Pack from "./ui/Pack.svelte";

  //console.log($ui);

</script>

<h3>Default: 
  <button on:click={()=> $ui = ["Main"] }>Main</button>
  <button on:click={()=> $ui = ["Pack"] }>Pack</button>
</h3>

{#if $ui.includes('Main') }  <Main /> {/if}
{#if $ui.includes('Pack') }  <Pack /> {/if}
  