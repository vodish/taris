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
    {"url": "/layer/request", "name":"Запросы", "_active": false },
    {"url": "/layer/handle", "name":"Обработчики", "_active": false },
    {"url": "/layer/page", "name":"Страницы", "_active": false },
]

menu = menu.map( v => {
    v._active = new RegExp($url.path).test(v.url)
    return v
} )

function handleMenu(e)
{
    href(e)
    menu = menu.map( v => {
        v._active = new RegExp($url.path).test(v.url)
        return v
    })

}



</script>

<svelte:head>
    <title>Layer</title>
</svelte:head>


<div class="menu">
    {#each menu as m }
        <a href="{m.url}" class:active={m._active} on:click={handleMenu}>{m.name}</a>
    {/each}
</div>


<div class="tile">
    {#each _pages as p }
        <div>
            <div class="name">{p.name}</div>
            <div class="id">{p.id}</div>
        </div>
    {/each}
</div>




<style>
    .menu   { margin: 2em 0; display: flex; gap: 20px; }
    .menu .active   { color: inherit; }


    .tile   { display: flex; gap: 30px; margin-top: 5em; border: solid 1px #555; padding: 20px; }
    .tile > div { border: solid 1px #444; padding: 20px; }
    .tile > div .id     { font-size: 0.8em; }
    .tile > div .name   { font-size: 1.2em; margin-top: 0.3em; }

</style>