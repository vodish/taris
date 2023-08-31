import { writable, get } from "svelte/store";


// главная

export let userList     =   writable(false)



// пачка
export let packId       =   writable(false)
export let packTitle    =   writable(false)
export let packBc       =   writable([])
export let packOption   =   writable(false)
export let packTree     =   writable([])
export let packView     =   writable('')
export let packAccess   =   writable(false)

export let textView     =   writable(false)
export let textTree     =   writable(false)
export let textAccess   =   writable(false)



export let line_content     =   writable("line_content")
export let tree_content     =   writable("tree_content")
export let access_content   =   writable("access_content")
