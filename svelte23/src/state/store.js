// @ts-nocheck
import { writable, get } from "svelte/store";
import { href, hpack, api, parse, popstate } from "./url";
// import { hpack } from "./pack";

// реэкспорт
export { get }
export { href, hpack, api, parse }


// окружение
export let url          =   writable()
export let rtoken       =   writable( document.body.dataset.rtoken )

export let userList     =   writable( false )

export let pack         =   writable( {bc: [], tree:[]} )
export let lineHtml     =   writable("")
export let lineText     =   writable("")
export let treeText     =   writable("")
export let accessText   =   writable("")



// инициализация
popstate()
window.addEventListener( "popstate",  popstate )







