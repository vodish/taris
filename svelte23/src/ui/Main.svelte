<script>
// @ts-nocheck

import { onMount } from "svelte";
import { api, userList, pref } from "../state/store";




// переменные входа

let emailRef;
let email       =   ""
let code        =   ""

let step        =   "email"
let delay
let error       =   ""
let load        =   false


// инициализация

onMount(() =>{

    emailRef.focus();

    if ( $userList == false )
    {   
        api( {userList:1, wait:["userList"]},  (res) => userList.set(res.userList) )
    }
});





// обработчики

function apiGetCode()
{
    step    =   "code"
    code    =   ""
    error   =   ""

    delay   =   2
    let timer =  setInterval(() => {
        delay--;
        if ( delay > 0 )    return;
        clearInterval(timer)
    }, 1000 )


    api({ userGetCode: email },  res => {
        if      ( res.href )            return pref(res.href);
        else if ( res.ok == "ok" )      return;
        else    error = "";
    })
}




function apiCheckCode()
{
    code    =   code.replace(/\D+/g, '')
    
    if ( code.length == 4 && load === false )
    {
        load = true;
        api({ userCheckCode: email, code }, res => {
            if      ( res.href )            return pref(res.href);
            else if ( res.ok == "ok" )      return;
            else if ( res.check )           error = res.check;
            else    error = "";
        })

    } else if ( code.length < 4 ) {
        load    =   false;
        error   =   ""
    }
}

</script>



<svelte:head>
    <title>Taris.pro</title>
</svelte:head>


<div class="main1">
    <div>
        <div class="auth">

            {#if step == "email" }

                <form class="login" on:submit|preventDefault={apiGetCode}>
                    <input class="email" type="email" name="email" bind:value={email} required={true} placeholder="Емеил для входа" title="Емеил для входа" bind:this={emailRef} />
                    <button class="send">Taris</button>
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
                    <a href={"/" + v.start} on:click={pref}>{v.email}</a>
                {/each}
            </div>
        {/if}
        

    </div>
</div>

