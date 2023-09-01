import { writable, get } from "svelte/store";
import { url, parse, api, href as changeUrl } from "./url";


// главная

export let userList     =   writable(false)



// пачка
export let view         =   writable("")
export let pack         =   writable({bc: [], tree:[]})

export let lineHtml     =   writable('')
export let lineText     =   writable('')
export let treeText     =   writable('')
export let accessText   =   writable('')

export let testAce      =   writable('фром сторе')




/**
 * @param {String | Object} href
 */
export function pack1(href)
{
    if ( typeof href === 'object'  && href.srcElement.tagName == "A")
    {
        href.preventDefault()
        href    =   href.srcElement.pathname
    }

    let $url    =   get(url);
    href        =   parse(href)
    

    // параметры запроса к api
    let data    =   { pack: href.level[0], view: "html" }

    if ( ! href.level[1] )
    {
        data.lineHtml   =   href.level[0]
    }
    else if ( href.level[1] == 'line' )
    {
        data.lineText   =   href.level[0]
        data.view       =   "line"
    }
    else if ( href.level[1] == 'tree' )
    {
        data.treeText   =   href.level[0]
        data.view       =   "triee"
    }
    else if ( href.level[1] == 'access' )
    {
        data.accessText =   href.level[0]
        data.view       =   "access"
    }


    api(data, (res) => {
        
        pack.set(res.pack)

        if ( res.lineHtml !== undefined )   { lineHtml.set(res.lineHtml) }
        if ( res.lineText !== undefined )   { lineText.set(res.lineText) }
        if ( res.treeText !== undefined )   { treeText.set(res.treeText) }
        if ( res.accessText !== undefined ) { accessText.set(res.accessText) }
        
        
        view.set(data.view)
        changeUrl(href.path)
        
    })
    
}



// /**
//  * @param {Object} data
//  * @param {(arg0: Object) => any} cb
//  */
// export function pack2(data, cb)
// {
    
//     let fd  =   new FormData()
//         fd.append("rtoken", get(rtoken))
//         for( let k in data )  fd.append(k, data[k])
    
//     let xhr =   new XMLHttpRequest()
//         xhr.open('POST', "/api");
//         xhr.responseType = 'json';
//         xhr.send(fd)
//         xhr.onload = () => {
//             if ( xhr.response && xhr.response.rtoken )      rtoken.set(xhr.response.rtoken)
//             cb(xhr.response)
//         }
// }
