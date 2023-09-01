import { writable, get } from "svelte/store";
import { url, rtoken, api, parse } from "./url";


// главная

export let userList     =   writable(false)



// пачка
export let view         =   writable("")
export let pack         =   writable({bc: [], tree:[]})

export let lineHtml     =   writable('')
export let lineText     =   writable('')
export let treeText     =   writable('')
export let accessText   =   writable('')




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
    let data    =   { pack: href.level[0] }

    if ( ! href.level[1] )
    {
        data.lineHtml   =   href.level[0]
        view.set("html")
    }
    else if ( href.level[1] == 'line' )
    {
        data.lineText   =   href.level[0]
        view.set("line")
    }
    else if ( href.level[1] == 'tree' )
    {
        data.treeText   =   href.level[0]
        view.set("triee")
    }
    else if ( href.level[1] == 'access' )
    {
        data.accessText =   href.level[0]
        view.set("access")
    }


    api(data, (res) => {
        // console.log(res)
        pack.set(res.pack)

        if ( res.lineHtml )     lineHtml.set(res.lineHtml || false)
        if ( res.lineText )     lineHtml.set(res.lineText)
        if ( res.treeText )     lineHtml.set(res.treeText)
        if ( res.accessText )   lineHtml.set(res.accessText)
        
    })
    
}



/**
 * @param {Object} data
 * @param {(arg0: Object) => any} cb
 */
export function pack2(data, cb)
{
    
    let fd  =   new FormData()
        fd.append("rtoken", get(rtoken))
        for( let k in data )  fd.append(k, data[k])
    
    let xhr =   new XMLHttpRequest()
        xhr.open('POST', "/api");
        xhr.responseType = 'json';
        xhr.send(fd)
        xhr.onload = () => {
            if ( xhr.response && xhr.response.rtoken )      rtoken.set(xhr.response.rtoken)
            cb(xhr.response)
        }
}
