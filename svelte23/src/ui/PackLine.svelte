<script>
import { onDestroy } from "svelte";
import { line_content } from "../state/pack";
import AceHtml from "./ace/AceHtml.svelte";

onDestroy(()=>{
  console.log(`сохранить line_content на сервере`)
})

</script>

<p>PackLine</p>

<hr>
<br>
<AceHtml bind:value={$line_content} />