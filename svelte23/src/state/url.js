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

export function href(href='')
{
    if ( window.location.pathname == href )  return;

    window.history.pushState({}, "", href)
    parse()
}
