// @ts-nocheck
import { writable, get } from "svelte/store";
import { href, api, parse, popstate } from "./url";
import { hpack } from "./pack";

// реэкспорт

export { get }
export { href, api, parse }
export { hpack }


// окружение
export let url          =   writable()
export let rtoken       =   writable( document.body.dataset.rtoken )

export let userList     =   writable( false )

export let pack         =   writable( {bc: [], tree:[]} )
export let lineHtml     =   writable( false )
export let lineText     =   writable( false )
export let treeText     =   writable( false )
export let accessText   =   writable( false )



// инициализация
popstate()
window.addEventListener( 'popstate',  popstate )







