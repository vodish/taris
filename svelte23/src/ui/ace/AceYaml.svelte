<script>
import { onMount } from "svelte";

// аттрибуты
export let value =  "";


onMount(()=> {
    // @ts-ignore
    let ace9    =   ace.edit('ace9');
    ace9.session.setMode('ace/mode/yaml')
    ace9.setOptions({
        minLines: 10,
        fontSize: "13px",
        fontFamily: "var(--font1)",
        showPrintMargin: false,     // граница печати
        showGutter: true,           // нумерация строк
        useWorker: false,           // отключить проверку синтаксиса - worker файл
        maxLines: 1111,             // максимальное количество строк, для ресайза
        wrap: true,                 // перенос строк
    })
    ace9.setValue(value, 1)
    ace9.on('change', () => value = ace9.getValue())
})
</script>

<div id="ace9" class="ace" />