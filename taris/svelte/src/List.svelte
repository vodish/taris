<script>
import Row from './Row.svelte'
import File from './File.svelte'


let root = 1;

let list = {
    1: [
        {
            id: 1123213,
            component: 'Row',
            content: `<div>Это сразу первая страница. Создать</div>
                    <ul>
                        <li>Проект</li>
                        <li>Файл</li>
                        <li>Обещание в нутри файла</li>
                    </ul>`
        },
        {
            id: 2234234,
            component: 'Row',
            content: `<p>Еще одна позиция</p>
                    <p>Еще одна позиция</p>`
        },
        {
            id: 334534,
            component: 'File',
            name: 'file.name',
            comment: `какой-то комментарий к файлу`
        },
        {
            id: 2234234,
            component: 'Row',
            content: `Являясь всего лишь частью общей картины, тщательные исследования конкурентов объединены в целые кластеры себе подобных. Повседневная практика показывает, что постоянный количественный рост и сфера нашей активности предполагает независимые способы реализации форм воздействия. `
        },
        {
            id: 2234234,
            component: 'Row',
            content: `Lorem ipsum dolor sit amet consectetur adipisicing elit. Suscipit nemo beatae ratione maiores quo. Odio labore ducimus ipsa adipisci maxime eligendi minus libero cumque veniam maiores. Atque nulla quidem perspiciatis. `
        },
    ],
    334534: [
        {
            id: 2776234,
            component: 'Row',
            content: `Являясь всего лишь частью общей картины, тщательные исследования конкурентов объединены в целые кластеры себее подобных. Повседневная практика показывает, что постоянный количественный рост и сфера нашей активности предполагает независимые способы реализации форм воздействия. `
        },
    ]
}

</script>



<p><a href="/">Выйти</a></p>

<div class="path">
    <menu>
        <li>Название объекта</li>
    </menu>
</div>


<div class="list">
    {#each list[root] as row }

        {#if row.component == 'File'}   <File {row} />
        {:else}                         <Row {row} />
        {/if}

    {/each}
</div>

<style>
    .path   { padding: 10px 0; border: solid 1px #999; border-width: 1px 0; margin-bottom: 1em; }
    .path   menu { list-style: none; margin: 0; padding: 0; display: flex; }
    
    .list   { display: flex; flex-direction: column; gap: 2em; }
</style>