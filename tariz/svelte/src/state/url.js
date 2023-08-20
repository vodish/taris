// @ts-nocheck
import { writable } from "svelte/store";


export let url    =   writable(parse())
window.addEventListener('popstate', () => url.set(parse()) )


export function parse()
{
    let path    =   window.location.pathname
    let level   =   path == '/' ?  [] :  path.substring(1).split('/')
    let dir     =   [];
    level.map( (v, i) => dir[i] = `${i ? dir[i-1]: ''}/${v}` )

    return {path, level, dir}
}

export function href(href='')
{
    if ( window.location.pathname == href )  return;

    window.history.pushState({}, "", href)
    url.set( parse() )
}
