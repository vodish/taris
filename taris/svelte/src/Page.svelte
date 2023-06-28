<script>
    let pathname = window.location.pathname

    // console.log( window.location.pathname )

    let list = [
        {
            'class': 'o',
            'text': `<div>Это сразу первая страница. Создать</div>
        <ul>
            <li>Проект</li>
            <li>Файл</li>
            <li>Обещание в нутри файла</li>
        </ul>`
        },
        {
            'class': 'o',
            'text': `<p>Еще одна позиция</p>
        <p>Еще одна позиция</p>`
        },
        {
            'class': 'o file',
            'text': `<a href="./name">name</a>`
        }
    ]

</script>

<p><a href="/">Выйти</a></p>

<div class="list">
    
    {#each list as o }
        <div class={o.class}>
            {@html o.text}
        </div>
    {/each}
    
</div>


<style>
    .list   { display: flex; flex-direction: column; gap: 2em; }
    .o      { border-left: solid 3px #444; padding-left: 1ch; }
</style>