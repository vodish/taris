<?php
load::$layout   =   'default.tpl.php';

# отправить код входа на емеил
#
user::actionLoginSend();

?>

<div class="main top">
    <img class="logo" src="/i/TZ.svg" />
    
    <div>
        <div class="auth" id="auth">
            <div class="login step1 active">
                <?= ftoken::input() ?>
                <input class="email" type="email" name="email" placeholder="Емеил для входа" required="true" />
                <button class="send" onclick="auth.send(event)">Войти</button>
            </div>

            <div class="login step2" method="post">
                <div>
                    <div>Код из письма</div>
                    <div class="err" style="display: none;">Неверный код...</div>
                </div>
                <input class="code" name="code" onkeyup="auth.keyup(event)" maxlength="4" autocomplete="off" />
            </div>
            <div class="note step2">
                <div class="wait active">Повторить отправку через <span class="delay">60</span> сек</div>
                <div class="back" onclick="auth.init()">Повторить отправку</div>
            </div>
            
        </div>
    </div>
    
</div>


<script src="<?= load::makefile('/t/main.js', 'main.js') ?>"></script>
