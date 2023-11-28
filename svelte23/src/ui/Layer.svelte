<script>
import { href, url } from "../state/store";





let _pages = [
    { "id": "page1", "name": "Главная/Меню", },
    { "id": "page2", "name": "Корзина", },
    { "id": "page3", "name": "Отправить", },
];

let _list = {
    "page1": { "type": "page", "name": "Главная/Меню", },
    "page2": { "type": "page", "name": "Корзина", },
    "page3": { "type": "page", "name": "Отправить", },
}

let menu = [
    {"url": "/layer/request", "name":"Запросы", },
    {"url": "/layer/handle", "name":"Обработчики", },
    {"url": "/layer/page", "name":"Страницы", },
]

/*
Страницы
    page1
    page2
    page3
    page4

*/

</script>

<svelte:head>
    <title>Layer</title>
</svelte:head>


<div class="menu">
    {#each menu as m }
        <a href="{m.url}" class="" on:click={href}>{m.name}</a>
    {/each}
</div>


<div class="tile">
    {#each _pages as p }
        <div class="">
            <div class="id">{p.id}</div>
            <div class="name">{p.name}</div>
        </div>
    {/each}
</div>




<style>
    .menu   { margin: 2em 0; display: flex; gap: 20px; }
    .menu   { margin: 2em 0; display: flex; gap: 20px; }


    .tile   { display: flex; gap: 30px; margin-top: 5em; border: solid 1px #555; padding: 20px; }
    .tile > div { border: solid 1px #444; padding: 20px; }
    .tile > div .id     { font-size: 0.8em; }
    .tile > div .name   { font-size: 1.2em; margin-top: 0.3em; }

</style>