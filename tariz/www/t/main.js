
// auth
useFtoken()

var auth = {
    $auth:      null,
    $step1:     null,
    $step2:     null,
    $err:       null,
    $delay:     null,
}



auth.send  =  function(e)
{
    e.preventDefault()
    
    // init
    auth.$auth      =   $(e.target).closest('.auth')
    auth.$step1     =   auth.$auth.children('.step1')
    auth.$step2     =   auth.$auth.children('.step2')
    auth.$err       =   auth.$step2.find('.err')
    auth.$delay     =   auth.$step2.find('.delay')

    auth.$err.css('display', 'none');
    auth.$delay.text('6222');


    // work
    auth.$step1.removeClass('active')
    auth.$step2.addClass('active')
}


auth.keyup = function(e)
{
    e.target.value = e.target.value.replace(/\D+/g, '')

    console.log( e.target.value )

    if ( e.target.value.length == 4 )
    {
        if ( e.target.value == '1234' )
        {
            let $auth = $(e.target).closest('.auth')
            $auth.children('.step1').addClass('active')
            $auth.children('.step2').removeClass('active')
        }
    }
}

