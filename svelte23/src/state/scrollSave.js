// @ts-nocheck

/**
 * @param {string} packStart
 */
export function saveScroll(key='')
{
    if ( key === '' )   return;

    sessionStorage.setItem(key, `${window.scrollY}`);
}

/**
 * @param {string} packStart
 */
export function setScroll(key)
{
    let scrollY =   sessionStorage.getItem(key);
        scrollY =   scrollY ?  Number(scrollY) :  0;
    
    window.scrollTo(0, scrollY)
}