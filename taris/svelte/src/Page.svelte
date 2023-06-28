<script>
    import { useUrl } from "./lib/url";

    let url = useUrl()
    // console.log( url )


    
    let list = {
        1: [
            {
                id: 1123213,
                class1: 'o',
                text: `<div>Это сразу первая страница. Создать</div>
                        <ul>
                            <li>Проект</li>
                            <li>Файл</li>
                            <li>Обещание в нутри файла</li>
                        </ul>`
            },
            {
                id: 2234234,
                class1: 'o',
                text: `<p>Еще одна позиция</p>
                        <p>Еще одна позиция</p>`
            },
            {
                id: 334534,
                class1: 'o file',
                text: `<a href="/1/334534">name</a>`
            },
            {
                id: 2234234,
                class1: 'o',
                text: `Являясь всего лишь частью общей картины, тщательные исследования конкурентов объединены в целые кластеры себе подобных. Повседневная практика показывает, что постоянный количественный рост и сфера нашей активности предполагает независимые способы реализации форм воздействия. `
            },
            {
                id: 2234234,
                class1: 'o',
                text: `Lorem ipsum dolor sit amet consectetur adipisicing elit. Suscipit nemo beatae ratione maiores quo. Odio labore ducimus ipsa adipisci maxime eligendi minus libero cumque veniam maiores. Atque nulla quidem perspiciatis. `
            },
        ],
        334534: [
            {
                id: 2776234,
                class1: 'o',
                text: `Являясь всего лишь частью общей картины, тщательные исследования конкурентов объединены в целые кластеры себе подобных. Повседневная практика показывает, что постоянный количественный рост и сфера нашей активности предполагает независимые способы реализации форм воздействия. `
            },
        ]
    }

</script>



<p><a href="/">Выйти</a></p>

<div class="list">
    
    {#each list[1] as {id, class1, text}, k }
        <div class={class1}>
            <a href="#{id+k}" class="id">#{id+k}</a>
            {@html text}
        </div>
    {/each}
    
</div>

<style>
    .list   { display: flex; flex-direction: column; gap: 2em; }
    .o      { border-left: solid 3px #444; padding-left: 1ch; max-width: 700px; }
    .o .id  { display: block; font-size: 10px; color: #444; }
</style>