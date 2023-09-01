<script>
import { lineText } from "../state/store";
import AceHtml from "./ace/AceHtml.svelte";


</script>

<AceHtml bind:value={$lineText} />
