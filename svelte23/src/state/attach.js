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
            console.log(res);
        });

        
        // ace1[0].focus();
        // ace1[0].execCommand("paste", '<p><img src="' + window.location.pathname + '/' + filename + '" /></p>')
    }
};




// attach.submit   =   async function(formData)
// {
//     let btn         =   $('#upload-bnt');
//         btn.addClass('active');
        
//     let response    =   await fetch(window.location.href, {method: 'POST', body: formData} );
//     //let result      =   await response.json();
//     let result      =   await response.text();
    
//     btn.removeClass('active');
//     //console.log(result);
    
    
//     $('#files').html(result);
// }