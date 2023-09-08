<script>
import { onDestroy } from "svelte";
import { accessText } from "../state/store";
import AceYaml from "./ace/AceYaml.svelte";

onDestroy(()=>{
    console.log(`обновить права на сервере`)
})
</script>


<AceYaml bind:value={$accessText} />
