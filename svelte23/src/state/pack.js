import { writable } from "svelte/store";


export let pack_bc          =   writable([])
export let pack_option      =   writable([])

export let tree_view        =   writable([])
export let line_view        =   writable("<div>yyy</div>")
export let access_view      =   writable("")

export let line_content     =   writable("line_content")
export let tree_content     =   writable("tree_content")
export let access_content   =   writable("access_content")
