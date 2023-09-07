// @ts-nocheck
import { writable, get } from "svelte/store";
import { popstate, href, api  } from "./url";
import { hpack } from "./pack";

// реэкспорт

export { get }
export { href, api }
export { hpack }


// окружение

export let url          =   writable( {} )
popstate()
window.addEventListener( 'popstate',  popstate )

export let rtoken       =   writable( document.body.dataset.rtoken )
export let data         =   writable( {} )


export let userList     =   writable( false )

export let pack         =   writable( {bc: [], tree:[]} )
export let lineHtml     =   writable( "" )
export let lineText     =   writable( "" )
export let treeText     =   writable( "" )
export let accessText   =   writable( "" )



// инициализация








