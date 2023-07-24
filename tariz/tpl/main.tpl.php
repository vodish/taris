<?php
load::$layout   =   'default.tpl.php';

# отправить код входа на емеил
#
user::actionLoginSend();

?>

<div class="main top">
    <img class="logo" src="/i/TZ.svg" />
    
    <div>

    <form class="login" method="post">
            <?= ftoken::input() ?>
            <input class="email" type="email" name="email" placeholder="Емеил для входа" required="true" />
            <button class="send">Войти</button>
        </form>

        <br>
        <br>

        <form class="login" method="post">
            <?= ftoken::input() ?>
            <div>
                <div>Код из письма</div>
            </div>
            <input class="code" name="code" placeholder="XXXX" required="true" />
        </form>
        
        <br>
        <br>

        <form class="login" method="post">
            <?= ftoken::input() ?>
            <div>
                <div>Код из письма</div>
                <div class="err">Плохой код...</div>
            </div>
            <input class="code" name="code" placeholder="XXXX" required="true" />
        </form>
        
        

    </div>
    
</div>
