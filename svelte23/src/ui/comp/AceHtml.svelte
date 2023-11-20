<script>
// @ts-nocheck
import { onMount, onDestroy } from "svelte";

// аттрибуты
export let value    =   ""


let ace9;

onMount(()=> {
    
    // @ts-ignore
    ace9    =   ace.edit('ace9');
    ace9.session.setMode('ace/mode/html')
    ace9.setOptions({
        minLines: 10,
        fontSize: "14px",
        fontFamily: "monospace",
        showPrintMargin: false,     // граница печати
        showGutter: true,           // нумерация строк
        useWorker: false,           // отключить проверку синтаксиса - worker файл
        maxLines: 1111,             // максимальное количество строк, для ресайза
        wrap: true,                 // перенос строк
    })
    ace9.setValue(value, 1)
    ace9.on('change', () => value = ace9.getValue())
    ace9.focus();

    let gotoLine = sessionStorage.getItem('gotoLine')
    ace9.gotoLine(gotoLine || 1);
})

onDestroy(()=>{

    // сохранить позицию курсора
    var currline = ace9.getSelectionRange().start.row;
    sessionStorage.setItem('gotoLine', currline+1);
    // console.log(currline)
})
</script>


<div id="ace9" class="ace" />
