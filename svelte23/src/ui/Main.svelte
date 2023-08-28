<script>
// @ts-nocheck
import { href, url } from "../state/url";


// переменные
let step        =   "email";
let email       =   "";
let code        =   "";
let userlist    =   [
    { url: "/1", email: "vodish@yandex.ru" },
    { url: "/558", email: "p.karasev@psw.ru" },
];

// console.log(step)


// обработчики
function send()
{
    console.log(email);
    step = "code";
}

function keyup()
{
    console.log(code);
    console.log(code.length);
}

function reset()
{

}
</script>


<div class="main1">
    <img class="pic1 active" src="/i/pic1.jpg" alt="Tariz" />
    <div>
        <div class="auth">

            {#if step == "email"}
                <div class="login">
                    <input class="email" type="email" bind:value={email} required={true} placeholder="Емеил для входа" title="Емеил для входа">
                    <button class="send" on:click={send}>Tariz</button>
                </div>
                
            {:else if step == "code"}
                <div class="login">
                    <div>
                        <div>Код из письма</div>
                        <div class="err"></div>
                    </div>
                    <input class="code" bind:value={code} on:keyup={keyup} maxlength="4" autocomplete="off">
                </div>
                <div class="note">
                    <div class="wait">Повторить отправку через <span class="delay">60</span> сек</div>
                    
                    <!-- svelte-ignore a11y-no-static-element-interactions -->
                    <!-- svelte-ignore a11y-click-events-have-key-events -->
                    <div class="back" on:click={reset}>Повторить вход</div>
                </div>
            {/if}

        </div>

        {#if userlist.length }
            <div class="userlist">
                {#each userlist as v }
                    <a href={v.url} on:click|preventDefault={(e)=>href(e.target.href)}>{v.email}</a>
                {/each}
            </div>
        {/if}

    </div>
</div>

