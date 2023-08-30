<script>
// @ts-nocheck
import { href, request } from "../state/url";


// переменные входа
let userlist    =   []
let email       =   ""
let code        =   ""


let step        =   "email"
let delay
let error       =   ""
let wait        =   false
let cssPic1     =   ""

// запросы

request('/api/user/list', {}, (res)=>{
    if ( !res || !res.userList ) {
        cssPic1 =   "empty"
        return
    }
    userlist    =   res.userList
    cssPic1     =   ""
})



// обработчики

function send()
{
    step    =   "code"
    code    =   ""
    error   =   ""

    delay   =   10
    let timer =  setInterval(() => {
        delay--;
        if ( delay > 0 )    return
        clearInterval(timer)
    }, 1000 )


    request('/api/user/get-code', { email }, (res)=>{
        if ( !res || res.send != "ok" ) {
            error = 'Error...'
        }
        console.log(res);
    })
}


function keyup(e)
{
    code    =   code.replace(/\D+/g, '')
    
    if ( code.length == 4 && wait === false )
    {
        wait = true;
        request('/api/user/check-code', { email, code }, (res)=>{
            
            error   =   res.check
            console.log(res);
        })

    } else if ( code.length < 4 ) {
        wait    =   false;
        error   =   ""
    }
}

</script>

<svelte:head>
    <title>Taris.pro - {window.location.host}</title>
</svelte:head>


<div class="main1">
    <img class="pic1 {cssPic1}" src="/i/pic1.jpg" alt="Taris" />
    <div>
        <div class="auth">

            {#if step == "email" }

                <form class="login" on:submit|preventDefault={send}>
                    <input class="email" type="email" name="email" bind:value={email} required={true} placeholder="Емеил для входа" title="Емеил для входа">
                    <button class="send">Tariz</button>
                </form>
                
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
                    <a href={"/" + v.start} on:click|preventDefault={(e)=>href(e.target.href)}>{v.email}</a>
                {/each}
            </div>

        {/if}
        

    </div>
</div>

