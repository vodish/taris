import { writable } from "svelte/store";


export let url =  writable({})
parse()
window.addEventListener('popstate', parse)

function parse()
{
    let path    =   window.location.pathname
    let level   =   path == '/' ?  [] :  path.substring(1).split('/')
    let dir     =   [];
    level.map( (v, i) => dir[i] = `${i ? dir[i-1]: ''}/${v}` )

    url.set({path, level, dir})
}

/**
 * @param {string} href
 */
export function href(href='')
{
    if ( window.location.pathname == href )  return;

    window.history.pushState({}, "", href)
    parse()
}


/**
 * @param {string | URL} url
 * @param {Object} data
 * @param {(arg0: Object) => any} cb
 */
export function request(url, data = {}, cb)
{
    let fd  =   new FormData()
    for( let k in data )  fd.append(k, data[k])
    
    let xhr =   new XMLHttpRequest()
    xhr.open('POST', url);
    xhr.responseType = 'json';
    xhr.send(fd)
    xhr.onload = () => cb(xhr.response)

    // xhr.onload = () => {
    //     if ( !xhr.response.send || xhr.response.send != 'ok' ) {
    //         error = 'Error...';
    //     }
    //     console.log(xhr.response);
    // }
}