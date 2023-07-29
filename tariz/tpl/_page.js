
document.addEventListener("DOMContentLoaded", function(e) {
    
    ace_init(".ace")
    
});


document.addEventListener('keydown', function(e) {
    
    if (e.code == 'KeyS' && (e.ctrlKey || e.metaKey))
    {
        e.preventDefault()
        $('#btn-save').click()
    }
});




function ace_init(selector)
{
    ace1    =  [];
    sess1   =  [];
    
    $(selector).each(function(i, t) {
        
        var aceid   =   'ace' + i;
        var $t      =   $(t);
        $t.hide();
        $t.after('<div id="' + aceid + '"></div>');
        
        ace1[i]   =   ace.edit(aceid, {
            mode: t.dataset.mode ?? null,
            minLines: 20,
            fontSize: "15px",
            maxLines: 1111,
            wrap: true,
            showPrintMargin: false,     // граница печати
            showGutter: true,           // нумерация строк
            useWorker: false,           // отключить проверку синтаксиса - worker файл
            // тема раскраски кода
            // theme: (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches ?  'ace/theme/tomorrow_night':  '')      
        });
        ace1[i].focus();
        // авторесайз
        ace1[i].setAutoScrollEditorIntoView(true);
        
        sess1[i] = ace1[i].getSession();
        sess1[i].setValue( $(t).val() );
        // сохранить обратно в textarea
        sess1[i].on('change', function(){
            $(t).val(sess1[i].getValue());
        });
        
    })
    
    //console.log(t);
}






function copyToClipboard(str)
{
    var area = document.createElement('textarea');
    document.body.appendChild(area);  
    area.value = str;
    area.select();
    document.execCommand("copy");
    document.body.removeChild(area);  
}







/* загрузка файлов из буфера обмена */


document.onpaste = function (event)
{
    var items = (event.clipboardData || event.originalEvent.clipboardData).items;
    
    for (var index in items)
    {
        if (items[index].kind !== 'file' && items[index].type != 'image/png')   continue;
        
        let blob        =   items[index].getAsFile();
        let datetime    =   new Date().toISOString().substring(0,19).replace(/[^\d]/g, '-');
        
        let filename    =   'image_' + datetime + '.png'
        let formData    =   new FormData();
            formData.set('attachActionUpload', 1);
            formData.append('f[]', blob, filename);
            
        //console.log(formData);
        //console.log(blob);
        attach.submit(formData);
        
        ace1[0].focus();
        ace1[0].execCommand("paste", '<p><img src="' + window.location.pathname + '/' + filename + '" /></p>')
    }
};




/* приложения */

attach  =   {};

attach.form     =   function(form)
{
    let formData    =   new FormData(form);
        formData.set('attachActionUpload', 1);
        
    this.submit(formData)
}


attach.submit   =   async function(formData)
{
    let btn         =   $('#upload-bnt');
        btn.addClass('active');
        
    let response    =   await fetch(window.location.href, {method: 'POST', body: formData} );
    //let result      =   await response.json();
    let result      =   await response.text();
    
    btn.removeClass('active');
    //console.log(result);
    
    
    $('#files').html(result);
}


attach.delete   =   function(t)
{
    let formData    =   new FormData();
        formData.set('attachActionDelete', 1);
        formData.set('name', $(t).closest('.descr').children('.name').text() );
    
    attach.submit(formData);
    //let response    =   await fetch(window.location.href, {method: 'POST', body: formData} );
    //let result      =   await response.text();
    
    //console.log(result);
}

