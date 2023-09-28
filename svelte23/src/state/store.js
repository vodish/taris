// @ts-nocheck
import { writable, get } from "svelte/store";
import { href, hpack, api, parse, popstate } from "./url";

// реэкспорт
export { get }
export { href, hpack, api, parse }


// окружение
export let url          =   writable()
export let apierr       =   writable( "" )

export let userList     =   writable( false )


export let packStart    =   writable( false )
export let packBc       =   writable( [] )
export let packHeap     =   writable( [] )
export let packMenu     =   writable( [] )
export let packTitle    =   writable( "" )
export let packProject  =   writable( false )

export let treePack     =   writable( [] )
export let treeText     =   writable( "" )

export let lineHtml     =   writable( "" )
export let lineText     =   writable( "" )

export let accessPack   =   writable( [] )
export let accessText   =   writable( "" )



// инициализация
popstate()
window.addEventListener( "popstate",  popstate )



