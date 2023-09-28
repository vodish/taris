<script>
import { packBc, packHeap, accessPack, accessText } from "../state/store";
import AceYaml from "./ace/AceYaml.svelte";

// onDestroy(()=>{
//     console.log(`обновить права на сервере`)
// })
</script>

<style>
    .pack   { margin-bottom: 2em; }
    .pack .name  { margin: 0.4em 0; border-bottom: solid 1px #555; }
    .pack .cont  { margin: 0.5em 0 0 7ch; }
</style>



{#each $packBc as v}
    <div class="pack">
        <div class="name">{$packHeap[ v ].name}</div>
        <div class="cont">
            Настройка
        </div>
    </div>
{/each}

<br />
<AceYaml bind:value={$accessText} />

<br />
<button>Сохранить</button>