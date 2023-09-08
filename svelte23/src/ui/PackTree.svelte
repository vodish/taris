<script>
import { onDestroy } from 'svelte';
import { treeText } from '../state/store';
import AceYaml from './ace/AceYaml.svelte';


onDestroy(()=>{
  console.log(`сохранить дерево проекта на сервере`)
})

</script>



<AceYaml bind:value={$treeText} />
