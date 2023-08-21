<script>
  import { line_content } from "../state/pack";

  import AceEditor from "./AceEditor.svelte";
  import "brace/mode/html";
  // import "brace/ext/emmet";
  // import "brace/mode/yaml";  
  let aceOptions = {
    // enableEmmet: true,
    minLines: 10,
    fontSize: "13px",
    fontFamily: "var(--font1)",
    showPrintMargin: false,   // граница печати
    showGutter: true,         // нумерация строк
    useWorker: false,         // отключить проверку синтаксиса - worker файл
    maxLines: 1111,           // максимальное количество строк, для ресайза
    wrap: true,               // перенос строк
  }

</script>

<p>PackLine</p>

<hr>
<br>
<AceEditor width="100%" mode="html" options={aceOptions} bind:value={$line_content} />