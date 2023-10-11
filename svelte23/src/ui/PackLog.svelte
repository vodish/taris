<script>
import { pref, packStart, logList } from "../state/store";
</script>

<table class="loglist">
    {#each $logList as v}
        <tr>
            <td class="id">#{v.id}</td>
            <td>{v.created}</td>
            <td>{v.author_email}</td>
            <td>{v.target_name}</td>
            <td><a href="/{$packStart}/logUp/{v.id}" on:click={pref}>{v.up_name}</a></td>
        </tr>
    {/each}
</table>