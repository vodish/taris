import { url, rtoken, get } from './store'



// слушатель адресной строки

export function popstate()
{
    url.set( parse(window.location.pathname) )
}





// вспомогательные функции общего назначения

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

    if ( window.location.pathname == href )     return


    window.history.pushState({}, "", href)
    popstate()
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
