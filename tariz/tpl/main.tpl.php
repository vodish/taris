<?php
load::$layout   =   'default.tpl.php';

# отправить код входа на емеил
#
user::actionLoginSend();

?>

<div class="main top">
    <form class="login" method="post">
        <?= ftoken::input() ?>
        <input class="email" type="email" name="email" placeholder="Емеил для входа" required="true" />
        <button class="send">Войти</button>
    </form>
    
    <img class="logo" src="/i/TZ.svg" />
    
</div>
