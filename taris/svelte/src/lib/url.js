export function useUrl()
{
  let path    = window.location.pathname
  let level   = []
  let dir     = []

  let _p = ''
  path.substring(1).split('/').forEach( item => level.push(_p += '/' + item) )

  

  return { path, dir, level }
}



