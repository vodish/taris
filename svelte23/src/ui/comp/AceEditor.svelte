<script>
// @ts-nocheck
import { onMount, onDestroy } from "svelte";


// аттрибуты

export let value    =   ""
export let mode     =   "html"

let setOptions      =   {
    html : {
        setMode: "ace/mode/html",
        minLines: 10,
        fontSize: "14px",
        fontFamily: "monospace",
        showPrintMargin: false,     // граница печати
        showGutter: false,           // нумерация строк
        useWorker: false,           // отключить проверку синтаксиса - worker файл
        maxLines: 1111,             // максимальное количество строк, для ресайза
        wrap: true,                 // перенос строк
    },
    yaml : {
        setMode: "ace/mode/yaml",
        minLines: 10,
        fontSize: "14px",
        fontFamily: "monospace",
        showPrintMargin: false,     // граница печати
        showGutter: true,           // нумерация строк
        useWorker: false,           // отключить проверку синтаксиса - worker файл
        maxLines: 1111,             // максимальное количество строк, для ресайза
        wrap: false,                // перенос строк
    },
}




// монтирование

onMount(()=> {
    
    window.ace9     =   ace.edit('ace9');
    window.ace9.session.setMode(setOptions[mode].setMode)
    window.ace9.setOptions(setOptions[mode])
    window.ace9.setValue(value, 1)
    window.ace9.on('change', () => value = window.ace9.getValue())
    window.ace9.focus();

    let gotoLine = sessionStorage.getItem('gotoLine')
    window.ace9.gotoLine(gotoLine || 1);

})

onDestroy(()=>{

    if ( mode == "html" )
    {
        // сохранить позицию курсора
        var currline    =   window.ace9.getSelectionRange().start.row;
        sessionStorage.setItem('gotoLine', currline+1);    
    }
    
    delete window.ace9;
})

</script>


<div id="ace9" class="ace" />
