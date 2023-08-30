<script>
// @ts-nocheck
import { href, request } from "../state/url";



// переменные входа
let userlist    =   []

let step        =   "email"
let email       =   ""
let code        =   ""
let error       =   ""
let delay
let rtoken      =   "rtoken123"
let wait        =   false


// запросы

request('/api/user/list', { rtoken }, (res)=>{
    if ( !res || !res.userList )    return
    userlist = res.userList
})


// обработчики

function send()
{
    step    =   "code"
    code    =   ""
    error   =   ""

    delay   =   3
    let timer =  setInterval(() => {
        delay--;
        if ( delay > 0 )    return
        clearInterval(timer)
    }, 1000 )


    request('/api/user/get-code', { rtoken, email }, (res)=>{
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
        request('/api/user/check-code', { rtoken, email, code }, (res)=>{
            
            rtoken  =   res.rtoken
            error   =   res.check
            console.log(res);
        })

    } else if ( code.length < 4 ) {
        wait    =   false;
        error   =   ""
    }
}



</script>


<div class="main1">
    <img class="pic1 { userlist.length > 0? "active": '' }" src="/i/pic1.jpg" alt="Tariz" />
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

