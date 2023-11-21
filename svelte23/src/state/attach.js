// @ts-nocheck
import { packStart, get }    from "../state/store";
import { api } from "./url";



export function upload(e)
{
    var items   =   (e.clipboardData || e.originalEvent.clipboardData).items
    
    for (var k in items)
    {
        if ( items[k].kind !== 'file'  &&  items[k].type != 'image/png' )    continue;
        
        let formData    =   new FormData()
            formData.set('pack', get(packStart))
            formData.set('attach', 'clipboard')
            formData.append('clipboard', items[k].getAsFile(), 'clipboard')
        
        api(formData, res => {
            window.ace9.execCommand("paste", `<img src="${res.clipboard}" />` )
            navigator.clipboard.writeText("")
        });

    }
}



