<script>
  import { uiDefault, href } from "./state/ui";
  import Main from "./ui/Main.svelte";
  import Pack from "./ui/Pack.svelte";

  //console.log($ui);

</script>

<h3>Default: 
  <button on:click={()=> {$uiDefault = ["Main"]; href("/"); } }>Main</button>
  <button on:click={()=> {$uiDefault = ["Pack"]; href("/1"); } }>Pack</button>
</h3>

{#if $uiDefault.includes('Main') }  <Main /> {/if}
{#if $uiDefault.includes('Pack') }  <Pack /> {/if}
  