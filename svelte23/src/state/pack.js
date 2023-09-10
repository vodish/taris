import * as store from "./store"



/**
 * @param {string | Object} href
 */
export function hpack(href)
{
    if ( typeof href === 'object'  && href.srcElement.tagName == "A") {
        href.preventDefault()
        href    =   href.srcElement.pathname
    }
    
    let url     =   store.parse(href)
    
    let wait    =   ["pack"]
    if      ( url.level[1] == undefined )  wait.push("lineHtml")
    else if ( url.level[1] == 'line' )     wait.push("lineText")
    else if ( url.level[1] == 'tree' )     wait.push("treeText")
    else if ( url.level[1] == 'access' )   wait.push("accessText")


    // обновить состояние
    // затем перейти по ссылке
    store.api({ pack: url.level[0], wait }, (res) => {
        
        wait.map((field)=>{
            if ( res[ field ] === undefined )   return
            store[field].set( res[ field ] )
        })
        
        store.href(href)
    })
    
}