// @ts-nocheck
import { writable, get } from "svelte/store";
import { href, api, parse  } from "./url";
import { hpack } from "./pack";

// реэкспорт

export { get }
export { href, api, parse }
export { hpack }


// окружение

export let url          =   writable( parse(window.location.pathname) )
window.addEventListener( 'popstate',  () => url.set( parse(window.location.pathname) ) )

export let rtoken       =   writable( document.body.dataset.rtoken )
export let data         =   writable( {} )


export let userList     =   writable( false )

export let pack         =   writable( {bc: [], tree:[]} )
export let lineHtml     =   writable( "" )
export let lineText     =   writable( "" )
export let treeText     =   writable( "" )
export let accessText   =   writable( "" )



// инициализация








