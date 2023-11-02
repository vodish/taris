<script>
// @ts-nocheck

import { onMount } from "svelte";
import { api, pref, href, userList, packStart, isProject, packBc, packTree, packMenu, packTitle, lineHtml } from "../state/store";




// переменные входа
let email       =   ""
let code        =   ""

let step        =   "email"
let delay;
let error       =   ""
let load        =   false



// инициализация
onMount(() =>{

    document.getElementById('email').focus()
    
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
    delay   =   60
    
    // фокус на поле кода
    setTimeout(()=>{document.getElementById('code').focus()} , 0)
    
    // таймер на поле кода
    let timer =  setInterval(() => {
        delay--;
        if ( delay > 0 )    return;
        clearInterval(timer)
    }, 1000 )

    // запрос кода
    api({ userGetCode: email },  res => {
        if ( res.ok == "ok" )   return;
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

            if ( res.err )  return error = res.err;

            if ( res.packStart ) {
                userList.set(res.userList)
                packStart.set(res.packStart)
                isProject.set(res.isProject)
                packBc.set(res.packBc)
                packTree.set(res.packTree)
                packMenu.set(res.packMenu)
                packTitle.set(res.packTitle)
                lineHtml.set(res.lineHtml)
                href(res.href);
            }
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
                    <input class="email" type="email" name="email" bind:value={email} required={true} placeholder="Емеил для входа" title="Емеил для входа" id="email" />
                    <button class="send">Taris</button>
                </form>
                
            {:else if step == "code"}
                
                <div class="login">
                    <div>
                        <div>Код из письма</div>
                        {#if error != ""} <div class="err">{error}</div> {/if}
                    </div>
                    <input class="code {error==""?"": "err"}" bind:value={code} on:keyup={apiCheckCode} maxlength="4" autocomplete="off" id="code" />
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

    <h3 class="about"><a href="/150" on:click={pref}>Что здесь происходит?</a></h3>
</div>

