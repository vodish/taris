<script>
import { onDestroy } from 'svelte';
import { tree_content } from '../state/pack';
import AceYaml from './ace/AceYaml.svelte';


onDestroy(()=>{
  console.log(`сохранить дерево проекта на сервере`)
})

</script>

<AceYaml bind:value={$tree_content} />