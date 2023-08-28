<script>
// @ts-nocheck
import { href, url } from "../state/url";


let userlist    =   [
    // { url: "/1", email: "vodish@yandex.ru" },
    // { url: "/558", email: "p.karasev@psw.ru" },
];


// переменные входа

let step        =   "email"
let email       =   ""
let code        =   ""
let error       =   ""
let delay


// обработчики

function send()
{
    step    =   "code"
    code    =   ""
    error   =   ""
    delay   =   5
    let timer =  setInterval(() => {
        delay--;
        if ( delay > 0 )    return
        clearInterval(timer)
    }, 1000 )
}


function keyup()
{
    code    =   code.replace(/\D+/g, '')

    if ( code.length == 4 )
    {
        error = "Отправить код на проверку"
    } else {
        error = ""
    }
}

</script>


<div class="main1">
    <img class="pic1 { userlist.length > 0? "active": '' }" src="/i/pic1.jpg" alt="Tariz" />
    <div>
        <div class="auth">

            {#if step == "email" }
                <div class="login">
                    <input class="email" type="email" bind:value={email} required={true} placeholder="Емеил для входа" title="Емеил для входа">
                    <button class="send" on:click={send}>Tariz</button>
                </div>
                
            {:else if step == "code"}
                <div class="login">
                    <div>
                        <div>Код из письма</div>
                        {#if error != ""} <div class="err">{error}</div> {/if}
                    </div>
                    <input class="code {error==""?"": "err"}" bind:value={code} on:keyup={keyup} maxlength="4" autocomplete="off">
                </div>

                {#if delay > 0}
                    <div class="note wait">Повторить отправку через <span class="delay">{delay}</span> сек</div>
                {:else}
                    <div class="note"><a href="/" class="back" on:click|preventDefault={()=>step="email"}>Повторить вход</a></div>
                {/if}
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

