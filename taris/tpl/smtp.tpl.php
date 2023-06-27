<?
if ( !empty($_GET['to']) )
{
    $smtp   =   new smtp();
        
    $result =  $smtp->send(
        'vodish@yandex.ru',
        'Тема письма' .time(),
        '<h3>Заголовок</h3>
        <p>Параграф</p>
        <p>Параграф</p>'
    );
    
    load::vd($result, 1);
}
else {
    ?>
    <form action="">
        <input name="to" />
        <input type="submit" />
    </form>
    <?
}

phpinfo();
?>