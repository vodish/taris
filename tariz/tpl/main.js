
// auth

var auth = {
    $auth:      null,
    $step1:     null,
    $step2:     null,
    $err:       null,
    $delay:     null,
    $timer:     null,
    $code:     null,

}

auth.init  =  function()
{
    useFtoken()
    this.$auth      =   $('#auth')
    this.$step1     =   this.$auth.children('.step1')
    this.$step2     =   this.$auth.children('.step2')
    this.$err       =   this.$step2.find('div.err')
    this.$delay     =   this.$step2.find('.delay')
    this.$note      =   this.$auth.children('.note.step2')
    this.$code      =   this.$step2.find('[name="code"]')


    this.$step1.addClass('active')
    this.$step2.removeClass('active')
    this.$err.css('display', 'none');
    this.$delay.text(2);
    this.$note.children('.wait').addClass('active')
    this.$note.children('.back').removeClass('active')
    this.$step1.find('[name="email"]').focus()

}

auth.init()


auth.send  =  function()
{
    this.timer();
    
    this.$step1.removeClass('active')
    this.$step2.addClass('active')

    this.$code.val('').removeClass('err').focus()
}



auth.keyup = function(e)
{
    e.target.value = e.target.value.replace(/\D+/g, '')
    this.$err.css('display', 'none')
    this.$code.removeClass('err')


    if ( e.target.value.length == 4 )
    {
        if ( e.target.value == '1234' )
        {
            let $auth = $(e.target).closest('.auth')
            this.$auth.children('.step1').addClass('active')
            this.$auth.children('.step2').removeClass('active')
        }
        else {
            this.$err.css('display', 'block')
            this.$code.addClass('err')
        }
    }
}


auth.timer  =  function()
{
    clearInterval(this.$timer);

    this.$timer     =   setInterval( function(){
        let cnt = Number(auth.$delay.text()) - 1;
        if ( cnt < 0 ) {
            clearInterval(auth.$timer);
            auth.$note.children('.wait').removeClass('active')
            auth.$note.children('.back').addClass('active')
        }
        auth.$delay.text(cnt)
    }, 1000 );
}
