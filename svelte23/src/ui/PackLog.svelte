<script>
import { pref, packStart, logList } from "../state/store";
</script>

<p>Это платный раздел. Суть в том, чтобы узнать кто когда и что отредактировал.</p>
<p>Если вы пользуетесь только для себя, то у вас не возникнет вопроса из серии "чьи ручонки что-то изменили?"</p>
<br>
<br>

<table class="loglist">
    {#each $logList as v}
        <tr>
            <td>{v.created}</td>
            <td>{v.author_email}</td>
            <td>{v.target_name}</td>
            <td><a href="/{$packStart}/logUp/{v.id}" on:click={pref}>{v.up_name}</a></td>
        </tr>
    {/each}
</table>