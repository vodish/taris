<script>
export let row = {};


</script>

<div class="row">
    <a href="#{row.id}" class="id">#{row.id}</a>
    <div class="content">{@html row.content}</div>
</div>


<style>
.row      { border-left: solid 3px #444; padding-left: 1ch; max-width: 700px; }
.row .id  { display: block; font-size: 10px; color: #444; }
</style>