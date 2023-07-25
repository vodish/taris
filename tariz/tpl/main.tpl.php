<?php
load::$layout   =   'default.tpl.php';

# отправить код входа на емеил
#
user::actionLoginSend();

?>

<div class="main top">
    <img class="logo" src="/i/TZ.svg" />
    
    <div>
        <div class="auth">
            <form class="login step1 active" method="post" onsubmit="auth.send(event)">
                <?= ftoken::input() ?>
                <input class="email" type="email" name="email" placeholder="Емеил для входа" required="true" />
                <button class="send">Войти</button>
            </form>

            <div class="login step2 active" method="post">
                <?= ftoken::input() ?>
                <div>
                    <div>Код из письма</div>
                    <div class="err" style="display: none;">Неверный код...</div>
                </div>
                <input class="code" name="code" placeholder="XXXX" required="true" onkeyup="auth.keyup(event)" maxlength="4" />
            </div>

            <div class="note step2">Повторить отправку через <span class="delay">60</span> сек</div>
            
        </div>

    </div>
    
</div>


<script src="<?= load::makefile('/t/main.js', 'main.js') ?>"></script>
