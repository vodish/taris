<?php
load::$layout   =   'default.tpl.php';


# авторизация
#
user::actionCodeSend();
user::actionCodeCheck();


# профили
#
$userList   =   user::dbUserList();

// load::vd( $userList );

?>

<div class="main1">
    <img class="logo" src="/i/TZ.svg" />
    
    <div>
        <div class="auth" id="auth">
            <div class="login step1 active">
                <?= ftoken::input() ?>
                <input class="email" type="email" name="email" placeholder="Емеил для входа" required="true" />
                <button class="send" onclick="auth.send()">Войти</button>
            </div>

            <div class="login step2" method="post">
                <div>
                    <div>Код из письма</div>
                    <div class="err" style="display: none;" data-check="..."></div>
                </div>
                <input class="code" name="code" onkeyup="auth.keyup(this)" maxlength="4" autocomplete="off" />
            </div>
            <div class="note step2">
                <div class="wait active">Повторить отправку через <span class="delay">60</span> сек</div>
                <div class="back" onclick="auth.init()">Повторить вход</div>
            </div>
            
        </div>

        <div class="userlist">
            <?
            foreach($userList as $v)
            {
                echo '<a href="/' .$v['start']. '">' .$v['email']. '</a>';
            }
            ?>
        </div>
    </div>
    
</div>


<script src="<?= load::makefile('/t/main.js', 'main.js') ?>"></script>
