
// form token
function useFtoken()
{
    $('input[name="ft"]').each(function(){  this.value = this.value.match( new RegExp(".{1," + this.value.match(/[3-9]/)[0] + "}", "g") ).reverse().join('')  })
}

