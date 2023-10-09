// @ts-nocheck
import * as Store from './store'

let rtoken  =   document.body.dataset.rtoken;






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
 */
export function pref(href)
{
    if ( typeof href === 'object'  && href.srcElement.tagName == "A") {
        href.preventDefault()
        href    =   href.srcElement.pathname
    }
    
    let url     =   Store.parse(href)
    let data    =   {
        pack: url.level[0],
        wait: [
            'packStart',
            'packProject',
            'packBc',
            'packTree',
            'packMenu',
            'packTitle',
        ]
    }
    

    // данные запроса
    if ( url.level[1] == undefined ) {
        data.wait.push("lineHtml")
    }
    else if ( url.level[1] == 'line' ) {
        data.wait.push("lineText")
    }
    else if ( url.level[1] == 'tree' ) {
        data.wait.push("treeText")
    }
    else if ( url.level[1] == 'access' ) {
        data.wait.push("accessText")
    }
    else if ( url.level[1] == 'treeAdd' ) {
        data.treeAdd  = 1
        data.wait.push(url.level[1])
        href    =   url.dir[0]
    }   
    else if ( url.level[1] == 'treeDell' ) {
        data.treeDel  = 1
        data.wait.push(url.level[1])
        href    =   url.dir[0]
    }
    
    
    // console.log(href)
    // console.log(data)
    // return;

    // обновить состояние
    // затем перейти по ссылке
    Store.api(data,  (res) => {
        
        data.wait.map((field)=>{
            if ( res[ field ] === undefined )   return;

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
            
            if ( res.rtoken )      rtoken = res.rtoken
            
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
