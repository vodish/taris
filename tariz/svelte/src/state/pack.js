import { writable } from "svelte/store";


export let pack_bc          =   writable([])
export let pack_option      =   writable([])
export let tree_view        =   writable([])
export let line_view        =   writable("<div>yyy</div>")

export let line_content     =   writable("yyy")
export let tree_content     =   writable("")
export let access_view      =   writable("")
export let access_content   =   writable("")

