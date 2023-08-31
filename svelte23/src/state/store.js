import { writable } from "svelte/store";


// главная

export let userList     =   writable([])


// пачка

export let packBc       =   writable([])
export let packOption   =   writable([])
export let packTree     =   writable([])
export let packView     =   writable("<div>yyy</div>")
export let packAccess   =   writable("")

export let textView     =   writable("line_content")
export let textTree     =   writable("tree_content")
export let textAccess   =   writable("access_content")



export let line_content     =   writable("line_content")
export let tree_content     =   writable("tree_content")
export let access_content   =   writable("access_content")
