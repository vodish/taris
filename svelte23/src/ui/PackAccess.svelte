<script>
import { onDestroy } from "svelte";
import { access_content } from "../state/pack";
import AceYaml from "./ace/AceYaml.svelte";

onDestroy(()=>{
    console.log(`обновить права на сервере`)
})
</script>


<AceYaml bind:value={$access_content} />
