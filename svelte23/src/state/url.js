// @ts-nocheck
import * as Store from './store'

let tag     =   document.getElementById('rtoken')
let rtoken  =   JSON.parse( tag.innerText );
tag.parentNode.removeChild(tag);





export function popstate()
{
    let url    =   parse(window.location.pathname)
    Store.url.set(url)


    // слежение за пачками: инициализация, вперед, назад
    if ( url.level[0] && url.level[0] != Store.get( Store.packStart ) )
    {
        pref( window.location.pathname )
    }
}




/**
 * @param {string | object} href
 */
export function href(href)
{   
    if ( typeof href === 'object'  && href.srcElement.tagName == "A") {
        href.preventDefault()
        href    =   href.srcElement.pathname
    }

    if ( window.location.pathname == href ) {
        return
    }


    window.history.pushState({}, "", href)
    Store.url.set( parse(href) )
}




/**
 * @param {string | Object} href
 * @param {Object} data
 */
export function pref(href, data1)
{
    if ( typeof href === 'object'  && href.srcElement.tagName == "A") {
        href.preventDefault()
        href    =   href.srcElement.pathname
    }
    
    // данные запроса
    let data = {href}
    for( let k in data1 || {} )     data[ k ] = data1[ k ]
    

    Store.api(data, (res) => {
        
        for ( let k in res )
        {
            if ( Store[k] && Store[k]['set'] )   Store[k].set( res[k] )
        }
        
        Store.href(res.href || href)
    })
    
}





/** парсит строку
 * @param {string} path
 */
export function parse(path)
{
    let level   =   path == '/' ?  [] :  path.substring(1).split('/')
    let dir     =   [];
    level.map( (v, i) => dir[i] = `${i ? dir[i-1]: ''}/${v}` )

    return {path, level, dir}
}







/**
 * @param {Object} data
 * @param {(arg0: Object) => any} cb
 */
export function api(data, cb)
{
    data.rtoken =   rtoken

    let formData = new FormData();
    toFd(formData, data);

    let xhr =   new XMLHttpRequest()
        xhr.open('POST', "/api");
        xhr.send(formData)
        xhr.onload = () => {

            let res = {};
            try     { res = JSON.parse(xhr.response) }
            catch   { Store.apierr.set(xhr.response) }
            
            if ( res.rtoken ) {
                rtoken = res.rtoken
                Store.apierr.set("")
            }      
            
            cb(res)
        }
}



function toFd(formData, data, parentKey)
{
    if (data && typeof data === 'object' && !(data instanceof Date) && !(data instanceof File) && !(data instanceof Blob))
    {
        Object.keys(data).forEach( key => toFd(formData,  data[key],  (parentKey ? `${parentKey}[${key}]` : key)) );
    }
    else {
        formData.append(parentKey,  (data == null ? '' : data) );
    }
}
