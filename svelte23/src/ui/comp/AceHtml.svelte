<script>
// @ts-nocheck
import { onMount, onDestroy } from "svelte";



// аттрибуты
export let value    =   ""

// определения





onMount(()=> {
    
    window.ace9    =   ace.edit('ace9');
    window.ace9.session.setMode('ace/mode/html')
    window.ace9.setOptions({
        minLines: 10,
        fontSize: "14px",
        fontFamily: "monospace",
        showPrintMargin: false,     // граница печати
        showGutter: false,          // нумерация строк
        useWorker: false,           // отключить проверку синтаксиса - worker файл
        maxLines: 1111,             // максимальное количество строк, для ресайза
        wrap: true,                 // перенос строк
    })
    window.ace9.setValue(value, 1)
    window.ace9.on('change', () => value = window.ace9.getValue())
    window.ace9.focus();

    let gotoLine = sessionStorage.getItem('gotoLine')
    window.ace9.gotoLine(gotoLine || 1);

})

onDestroy(()=>{

    // сохранить позицию курсора
    var currline = window.ace9.getSelectionRange().start.row;
    sessionStorage.setItem('gotoLine', currline+1);    

    delete window.ace9;
})



// console.log(ace9)
// if ( ace9 )
// {
//     window.ace9.execCommand("paste", '<img src="clipboard" />')
// }

</script>


<div id="ace9" class="ace" />
