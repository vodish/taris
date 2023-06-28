export function useUrl()
{
  let path    = window.location.pathname
  let level   = []
  let dir     = []
  let hash    = window.location.hash

  let _p = ''
  path.substring(1).split('/').forEach( item => level.push(_p += '/' + item) )

  console.log(window.location)

  return { path, dir, level, hash }
}



