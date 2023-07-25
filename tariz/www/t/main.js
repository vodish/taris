
// auth

var auth = {
    $auth:      null,
    $step1:     null,
    $step2:     null,
    $err:       null,
    $delay:     null,
    $timer:     null,
}


auth.send  =  function(e)
{
    // init
    useFtoken()
    auth.$auth      =   $(e.target).closest('.auth')
    auth.$step1     =   auth.$auth.children('.step1')
    auth.$step2     =   auth.$auth.children('.step2')
    auth.$err       =   auth.$step2.find('.err')
    auth.$delay     =   auth.$step2.find('.delay')

    auth.$err.css('display', 'none');
    auth.$delay.text('60');

    clearInterval(auth.$timer);
    auth.$timer     =   setInterval( function(){
        let cnt = Number(auth.$delay.text()) - 1;
        auth.$delay.text(cnt)
    }, 1000 );

    // work
    auth.$step1.removeClass('active')
    auth.$step2.addClass('active')
}


auth.keyup = function(e)
{
    e.target.value = e.target.value.replace(/\D+/g, '')

    console.log( e.target.value )

    auth.$err.css('display', 'none')

    if ( e.target.value.length == 4 )
    {
        if ( e.target.value == '1234' )
        {
            let $auth = $(e.target).closest('.auth')
            $auth.children('.step1').addClass('active')
            $auth.children('.step2').removeClass('active')
        }
        else {
            auth.$err.css('display', 'block')
        }
    }
}

