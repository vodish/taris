<?
line::dbInit();
?>

<div class="pro">
    <div class="tree">
        <?= project::treeHtml( project::$id ) ?>
    </div>
    <div class="file">
        <?
        foreach(line::$list as $v)  echo $v['view'];
        ?>
    </div>
</div>

<script>
    setTimeout(()=>{ $('#saved').css('display', 'none') }, 2000)
    
    document.addEventListener('keydown', (e) => {
        if ( ['KeyS'].includes(e.code)  &&  (e.ctrlKey || e.metaKey) ) {
            e.preventDefault()
            $('#edit')[0].click()
        }
    })
</script>
