<script lang="ts">
  /**
   * svelte component https://www.npmjs.com/package/svelte-ace
   * based by https://github.com/thlorenz/brace
   * 
   * translation of vue component to svelte:
   * @link https://github.com/chairuosen/vue2-ace-editor/blob/91051422b36482eaf94271f1a263afa4b998f099/index.js
   **/


  import { createEventDispatcher, tick, onMount, onDestroy } from "svelte";
  import * as ace from "brace";

  const EDITOR_ID = `svelte-ace-editor-div:${Math.floor(
    Math.random() * 10000000000
  )}`;

  const dispatch = createEventDispatcher<{
    init: ace.Editor;
    input: string;
    selectionChange: any;
    blur: void;
    changeMode: any;
    commandKey: { err: any; hashId: any; keyCode: any };
    copy: void;
    cursorChange: void;
    cut: void;
    documentChange: { data: any };
    focus: void;
    paste: string;
  }>();



  export let value: string = ""; // String, required
  export let mode: string = "text"; // String
  // export let theme: string = ""; // String
  export let height: string = "100%"; // null for 100, else integer, used as percent
  export let width: string = "100%"; // null for 100, else integer, used as percent
  export let options: any = {}; // Object
  export let readonly: boolean = false;

  let editor: ace.Editor;
  let contentBackup: string = "";

  const requireEditorPlugins = () => {};
  requireEditorPlugins();

  onDestroy(() => {
    if (editor) {
      editor.destroy();
      editor.container.remove();
    }
  });

  $: watchValue(value);
  function watchValue(val: string) {
    if (contentBackup !== val && editor && typeof val === "string") {
      editor.session.setValue(val);
      contentBackup = val;
    }
  }

  // $: watchTheme(theme);
  // function watchTheme(newTheme: string) {
  //   if (editor) {
  //     editor.setTheme("ace/theme/" + newTheme);
  //   }
  // }

  $: watchMode(mode);
  function watchMode(newOption: any) {
    if (editor) {
      editor.getSession().setMode("ace/mode/" + newOption);
    }
  }

  $: watchOptions(options);
  function watchOptions(newOption: any) {
    if (editor) {
      editor.setOptions(newOption);
    }
  }

  $: watchReadOnlyFlag(readonly);
  function watchReadOnlyFlag(flag) {
    if (editor) {
      editor.setReadOnly(flag);
    }
  }

  const resizeOnNextTick = () =>
    tick().then(() => {
      if (editor) {
        editor.resize();
      }
    });

  $: if (height !== null && width !== null) {
    resizeOnNextTick();
  }

  onMount(() => {

    mode = mode || "text";
    
    editor = ace.edit(EDITOR_ID);
    dispatch("init", editor);
    editor.$blockScrolling = Infinity;
    editor.getSession().setMode("ace/mode/" + mode);
    editor.setValue(value, 1);
    editor.setReadOnly(readonly)
    contentBackup = value;
    setEventCallBacks();
    if (options.theme)  editor.setTheme("ace/theme/" + options.theme);
    if (options)        editor.setOptions(options);
  });

  const ValidPxDigitsRegEx = /^\d*$/;
  function px(n: string): string {
    if (ValidPxDigitsRegEx.test(n)) {
      return n + "px";
    }
    return n;
  }

  function setEventCallBacks() {
    editor.onBlur = () => dispatch("blur");
    editor.onChangeMode = (obj) => dispatch("changeMode", obj);
    editor.onCommandKey = (err, hashId, keyCode) =>
      dispatch("commandKey", { err, hashId, keyCode });
    editor.onCopy = () => dispatch("copy");
    editor.onCursorChange = () => dispatch("cursorChange");
    editor.onCut = () => {
      const copyText = editor.getCopyText();
      //console.log("cut event : ", copyText);
      editor.insert("");
      dispatch("cut");
    };
    editor.onDocumentChange = (obj: { data: any }) =>
      dispatch("documentChange", obj);
    editor.onFocus = () => dispatch("focus");
    editor.onPaste = (text) => {
      //console.log("paste event : ", text);
      editor.insert(text);
      dispatch("paste", text);
    };
    editor.onSelectionChange = (obj) => dispatch("selectionChange", obj);
    editor.on("change", function () {
      const content = editor.getValue();
      value = content;
      dispatch("input", content);
      contentBackup = content;
    });
  }
</script>

<div id={EDITOR_ID} style="width:{px(width)};height:{px(height)};" />