<script>
export let row = {};

</script>

<div class="file">
    <a href="#{row.id}" class="id">#{row.id}</a>
    <div class="name"><a href="{row.id}">{row.name}</a></div>
</div>


<style>
.file      { border-left: solid 3px #444; padding-left: 1ch; max-width: 700px; }
.file .id  { display: block; font-size: 10px; color: #444; }
</style>