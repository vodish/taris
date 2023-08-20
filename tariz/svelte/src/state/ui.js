import { writable } from "svelte/store";

// изменение url через кнопки навигации в браузере
window.addEventListener('popstate', function() { 
    console.log("popstate");
    console.log( window.location )
});


export function href(url)
{
    window.history.pushState({}, "", url);
}

export const uiDefault     =   writable(["Main"])
export const uiMain        =   writable(["Item"])
export const uiPack        =   writable(["View"])
