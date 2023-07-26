
// auth

var auth = {

    init: function() {
        this.$auth      =   $('#auth')
        this.$step1     =   this.$auth.children('.step1')
        this.$step2     =   this.$auth.children('.step2')
        this.$err       =   this.$step2.find('div.err')
        this.$delay     =   this.$step2.find('.delay')
        this.$note      =   this.$auth.children('.note.step2')
        this.$ft        =   this.$step1.find('[name="ft"]')
        this.$email     =   this.$step1.find('[name="email"]')
        this.$code      =   this.$step2.find('[name="code"]')

        this.$step1.addClass('active')
        this.$step2.removeClass('active')
        this.$err.css('display', 'none');
        this.$delay.text(2);
        this.$note.children('.wait').addClass('active')
        this.$note.children('.back').removeClass('active')
        this.$step1.find('[name="email"]').focus()
    },
    
    timer: function()
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
    },
    

    request: function(url, formData, onload)
    {
        let xhr =   new XMLHttpRequest()
        xhr.open('POST', url);
        xhr.responseType = 'json';
        xhr.send(formData)
        xhr.onload = onload;
    },



}

useFtoken()
auth.init()


auth.send  =  function()
{
    this.timer();
    
    this.$step1.removeClass('active')
    this.$step2.addClass('active')
    this.$code.val('').removeClass('err').focus()


    let fd  =   new FormData(document.forms.person);
    fd.append('actionCodeSend', 1);
    fd.append('ft', this.$ft.val());
    fd.append('email', this.$email.val());

    this.request('/', fd, function() {
        console.log(this.response);
    })
    
}



auth.keyup = function(t)
{
    t.value = t.value.replace(/\D+/g, '')
    this.$err.css('display', 'none')
    this.$code.removeClass('err')


    if ( t.value.length == 4 )
    {
        let fd  =   new FormData(document.forms.person);
        fd.append('actionCodeCheck', 1);
        fd.append('ft', this.$ft.val());
        fd.append('email', this.$email.val());
        fd.append('code', this.$code.val());

        auth.$err.text( auth.$err.attr('data-check') )
        auth.$err.css('display', 'block')

        this.request('/', fd, function() {

            if ( this.response.redir ) {
                auth.$err.text( this.response.check )
                return  window.location = this.response.redir
            }

            if ( this.response.check ) {
                auth.$err.text( this.response.check )
                auth.$code.addClass('err')
            }
            
        })
    }
}

