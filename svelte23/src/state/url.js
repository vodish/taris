import {get as storeGet, writable} from 'svelte/store'


export let url      =   writable({})
export let rtoken   =   writable(document.body.dataset.rtoken)


// инициализация и отслеживание

url.set( parse(window.location.pathname) )
window.addEventListener('popstate', () => url.set( parse(window.location.pathname) ) )


// console.log( storeGet(url) )

// экспортные функции


/**
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
 * @param {string | object} href
 */
export function href(href)
{   
    if ( typeof href === 'object'  && href.srcElement.tagName == "A")
    {
        href.preventDefault()
        href    =   href.srcElement.pathname
    }

    if ( window.location.pathname != href )
    {
        window.history.pushState({}, "", href)
        url.set( parse(href) )
    }
}



/**
 * @param {Object} data
 * @param {(arg0: Object) => any} cb
 */
export function api(data, cb)
{
    let fd  =   new FormData()
        fd.append("rtoken", storeGet(rtoken))
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




