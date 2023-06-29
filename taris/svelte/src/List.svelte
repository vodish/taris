<script>
import ListRow from './ListRow.svelte'
import ListFile from './ListFile.svelte'


let root = 'root';

let list = {
    'root' : {
        dir: [''],
        rows: ['13', '14', '12', '232', '231'],
    },
    '13': {
        id: '13',
        dir: ['root'],
        type: 'Row',
        content: `<div>Это сразу первая страница. Создать</div>
                <ul>
                    <li>Проект</li>
                    <li>Файл</li>
                    <li>Обещание в нутри файла</li>
                </ul>`,
    },
    '14': {
        id: '14',
        dir: ['root'],
        type: 'Row',
        content: `<p>Еще одна позиция</p>
                <p>Еще одна позиция</p>`,
    },
    '12': {
        id: '12',
        dir: ['root'],
        rows: ['42'],
        type: 'File',
        name: 'file.name',
        comment: `какой-то комментарий к файлу`,
    },
    '232': {
        id: '232',
        dir: ['root'],
        type: 'Row',
        content: `Являясь всего лишь частью общей картины, тщательные исследования конкурентов объединены в целые кластеры себе подобных. Повседневная практика показывает, что постоянный количественный рост и сфера нашей активности предполагает независимые способы реализации форм воздействия. `
    },
    '231':{
        id: '231',
        dir: ['root'],
        type: 'Row',
        content: `Lorem ipsum dolor sit amet consectetur adipisicing elit. Suscipit nemo beatae ratione maiores quo. Odio labore ducimus ipsa adipisci maxime eligendi minus libero cumque veniam maiores. Atque nulla quidem perspiciatis. `
    },
    '42': {
        id: '42',
        dir: ['root', '12'],
        type: 'Row',
        content: `Являясь всего лишь частью общей картины, тщательные исследования конкурентов объединены в целые кластеры себее подобных. Повседневная практика показывает, что постоянный количественный рост и сфера нашей активности предполагает независимые способы реализации форм воздействия. `
    },
}

</script>



<p style="text-align: center;"><a href="/">Выйти</a></p>

<div class="flex">
    <div class="tree">
        <div class="tabs">
            <div>Папки</div>
            <div>Структура</div>
        </div>
        <menu>
            <li>Taris</li>
            <li>index.html</li>
            <li>index.js</li>
            <li>App.svelte</li>
            <li>List.svelte</li>
        </menu>

        <menu style="display: none;">
            <li>Taris</li>
            <li>index.html</li>
            <li>index.js</li>
            <li>App.svelte</li>
            <li>List.svelte</li>
        </menu>
    </div>

    <div class="main">
        <div class="path">
            <menu>
                <li>User / File / File.name</li>
            </menu>
        </div>

        <div class="list">
            {#each list[root].rows as id }

                {#if list[id].type == 'File'}   <ListFile row={list[id]} />
                {:else}                         <ListRow row={list[id]} />
                {/if}

            {/each}
        </div>
    </div>
</div>





<style>
menu    { list-style: none; padding: 0; margin: 0; }

.flex   { display: flex; gap: 40px; }
.flex   .tree   { flex-basis: 150px; }
.flex   .tree   .tabs   { display: flex; justify-content: space-between; font-size: 10px; text-transform: uppercase; margin-bottom: 20px; }

.flex   .main   { flex-basis: 400px; flex-grow: 1; }
.flex   .main   .path   { padding: 10px 0; border: solid 1px #999; border-width: 1px 0; margin-bottom: 1em; }
.flex   .main   .path   menu { list-style: none; margin: 0; padding: 0; display: flex; }

.flex   .main   .list   { display: flex; flex-direction: column; gap: 2em; }
</style>