import { writable } from "svelte/store";


export let pack_bc          =   writable([])
export let pack_option      =   writable([])
export let tree_view        =   writable([])
export let line_view        =   writable("<div>yyy</div>")

export let line_content     =   writable("yyy")
export let tree_content     =   writable("")
export let access_view      =   writable("")
export let access_content   =   writable("")

export let ace_option       =   {
    // enableEmmet: true,
    minLines: 10,
    fontSize: "13px",
    fontFamily: "var(--font1)",
    showPrintMargin: false,   // граница печати
    showGutter: true,         // нумерация строк
    useWorker: false,         // отключить проверку синтаксиса - worker файл
    maxLines: 1111,           // максимальное количество строк, для ресайза
    wrap: true,               // перенос строк
}

