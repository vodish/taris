<script>
// @ts-nocheck
import { api, userList, hpack } from "../state/store";


// инициализация

if ( $userList == false )
{   
    api( {userList:1},  ({ userList: list }) => userList.set(list) )
}



// переменные входа

let email       =   ""
let code        =   ""

let step        =   "email"
let delay
let error       =   ""
let wait        =   false



// обработчики


function apiGetCode()
{
    step    =   "code"
    code    =   ""
    error   =   ""

    delay   =   2
    let timer =  setInterval(() => {
        delay--;
        if ( delay > 0 )    return
        clearInterval(timer)
    }, 1000 )


    api({ userGetCode:1, email }, ({send, code})=>{
        if ( send != "ok" ) {
            error = 'Error...'
        }
        console.log(code);
    })
}


function apiCheckCode(e)
{
    code    =   code.replace(/\D+/g, '')
    
    if ( code.length == 4 && wait === false )
    {
        wait = true;
        api({ userCheckCode:1, email, code }, ({check})=>{
            
            if ( check != "ok" ) {
                error = 'Error...'
            }
            error   =   check
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
    <img class="pic1 {$userList.length==0? 'empty': ''}" src="/i/pic1.jpg" alt="Taris" />
    <div>
        <div class="auth">

            {#if step == "email" }

                <form class="login" on:submit|preventDefault={apiGetCode}>
                    <input class="email" type="email" name="email" bind:value={email} required={true} placeholder="Емеил для входа" title="Емеил для входа">
                    <button class="send">Tariz</button>
                </form>
                
            {:else if step == "code"}
                
                <div class="login">
                    <div>
                        <div>Код из письма</div>
                        {#if error != ""} <div class="err">{error}</div> {/if}
                    </div>
                    <input class="code {error==""?"": "err"}" bind:value={code} on:keyup={apiCheckCode} maxlength="4" autocomplete="off">
                </div>

                {#if delay > 0}
                    <div class="note wait">Повторить отправку через <span class="delay">{delay}</span> сек</div>
                {:else}
                    <div class="note"><a href="/" class="back" on:click|preventDefault={()=>step="email"}>Повторить вход</a></div>
                {/if}

            {/if}

        </div>

        {#if $userList && $userList.length }

            <div class="userlist">
                {#each $userList as v }
                    <a href={"/" + v.start} on:click={hpack}>{v.email}</a>
                {/each}
            </div>

        {/if}
        

    </div>
</div>

