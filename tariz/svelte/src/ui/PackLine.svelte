<script>
  import AceEditor from "./AceEditor.svelte";
  import "brace/mode/html";
  // import "brace/mode/yaml";
  let text = "tttt";

  let aceOptions = {
    minLines: 10,
    fontSize: "13px",
    fontFamily: "Source Code Pro",
    showPrintMargin: false, // граница печати
    showGutter: true,      // нумерация строк
    useWorker: false,       // отключить проверку синтаксиса - worker файл
    maxLines: 1111,         // максимальное количество строк, для ресайза
    enableEmmet: true,
    wrap: true,
  }
</script>

<p>PackLine</p>

<hr>
<br>
<AceEditor
  width="100%"
  lang="html"
  value={text}
  options={aceOptions} />