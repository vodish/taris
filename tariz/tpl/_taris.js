$(document).ready(function(){
    
    $('form>input[name="t"]').each(function(){ this.value = this.value.match( new RegExp(".{1," + this.value.match(/[3-9]/)[0] + "}", "g") ).reverse().join('') })

})


    