// @ts-nocheck
import { writable, get } from "svelte/store";
import { href, pref, api, parse, popstate } from "./url";

// реэкспорт
export { get }
export { href, pref, api, parse }


// окружение
export let url              =   writable()
export let apierr           =   writable( "" )

export let userList         =   writable( false )


export let packStart        =   writable( false )
export let isProject        =   writable( false )
export let packBc           =   writable( [] )
export let packTree         =   writable( [] )
export let packMenu         =   writable( {name:''} )
export let packTitle        =   writable( "" )

export let treeText         =   writable( "" )

export let lineHtml         =   writable( "" )
export let lineText         =   writable( "" )

export let accessText       =   writable( "" )
export let logList          =   writable( [] )


// инициализация
popstate()
window.addEventListener( "popstate",  popstate )



