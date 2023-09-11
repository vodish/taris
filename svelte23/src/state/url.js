// @ts-nocheck
import { url, rtoken, get, pack } from './store'
import * as Store from './store'


export function popstate()
{
    let url1    =   parse(window.location.pathname)
    url.set(url1)


    // слежение за пачками: инициализация, вперед, назад
    if ( url1.level[0] && url1.level[0] != get(pack).start )
    {
        hpack( window.location.pathname )
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
    url.set( parse(href) )
}




/**
 * @param {string | Object} href
 */
export function hpack(href)
{
    if ( typeof href === 'object'  && href.srcElement.tagName == "A") {
        href.preventDefault()
        href    =   href.srcElement.pathname
    }
    
    let parse   =   Store.parse(href)
    let wait    =   ["pack"]
    
    if      ( parse.level[1] == undefined )  wait.push("lineHtml")
    else if ( parse.level[1] == 'line' )     wait.push("lineText")
    else if ( parse.level[1] == 'tree' )     wait.push("treeText")
    else if ( parse.level[1] == 'access' )   wait.push("accessText")


    // обновить состояние
    // затем перейти по ссылке
    Store.api({ pack: parse.level[0], wait }, (res) => {
        
        wait.map((field)=>{
            if ( res[ field ] === undefined )   return
            Store[field].set( res[ field ] )
        })
        
        Store.href(href)
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
    data.rtoken =   get(rtoken)

    let formData = new FormData();
    buildFormData(formData, data);

    let xhr =   new XMLHttpRequest()
        xhr.open('POST', "/api");
        xhr.responseType = 'json';
        xhr.send(formData)
        xhr.onload = () => {
            if ( xhr.response && xhr.response.rtoken )      rtoken.set(xhr.response.rtoken)
            cb(xhr.response)
        }
}



function buildFormData(formData, data, parentKey)
{
    if (data && typeof data === 'object' && !(data instanceof Date) && !(data instanceof File) && !(data instanceof Blob)) {
        Object.keys(data).forEach(key => {
            buildFormData(formData, data[key], parentKey ? `${parentKey}[${key}]` : key);
        });
    } else {
        const value = data == null ? '' : data;

        formData.append(parentKey, value);
    }
}
