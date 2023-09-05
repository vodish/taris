// @ts-nocheck
import { writable, get } from "svelte/store";
import { url, parse, api, href } from "./url";

// компоненты
export let ui           =   writable([])


// главная
export let userList     =   writable(false)


// пачка
export let view         =   writable("")
export let pack         =   writable({bc: [], tree:[]})
export let lineHtml     =   writable('')
export let lineText     =   writable('')
export let treeText     =   writable('')
export let accessText   =   writable('')





export function pack1(_href)
{
    if ( typeof _href === 'object'  && _href.srcElement.tagName == "A")
    {
        _href.preventDefault()
        _href    =   _href.srcElement.pathname
    }

    ui.update(v => v.push("Pack.svelte") )
    _href        =   parse(_href)
    

    // параметры запроса к api
    let data    =   { pack: _href.level[0], view: "html" }

    if ( ! _href.level[1] )
    {
        data.lineHtml   =   _href.level[0]
    }
    else if ( _href.level[1] == 'line' )
    {
        data.lineText   =   _href.level[0]
        data.view       =   "line"
    }
    else if ( _href.level[1] == 'tree' )
    {
        data.treeText   =   _href.level[0]
        data.view       =   "triee"
    }
    else if ( _href.level[1] == 'access' )
    {
        data.accessText =   _href.level[0]
        data.view       =   "access"
    }


    api(data, (res) => {
        
        pack.set(res.pack)

        if ( res.lineHtml !== undefined )   { lineHtml.set(res.lineHtml) }
        if ( res.lineText !== undefined )   { lineText.set(res.lineText) }
        if ( res.treeText !== undefined )   { treeText.set(res.treeText) }
        if ( res.accessText !== undefined ) { accessText.set(res.accessText) }
        
        
        view.set(data.view)
        href(_href.path)
        

        console.log( get(ui) )
    })
    
}


