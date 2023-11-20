// @ts-nocheck
import { api } from "./url";

export function upload(e)
{
    var items = (e.clipboardData || e.originalEvent.clipboardData).items;
    
    for (var index in items)
    {
        if (items[index].kind !== 'file' && items[index].type != 'image/png')   continue;
        
        let blob        =   items[index].getAsFile()
        
        
        let formData    =   new FormData()
            formData.set('[]', 'attachUpload')
            formData.set('attachUpload', '1')
            formData.append('f[]', blob, 'bufer.png')
        
        api(formData, res => {
            console.log(res);
        });
        //console.log(blob);
        // submit(formData);
        
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