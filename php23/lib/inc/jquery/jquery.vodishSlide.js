(function( $ ){

      $.fn.vodishslide = function( options ) {  
        
        /* for example to `options`
        var settings = $.extend( {
          'rotate'         : '',
        }, options); */
        
        
        var $self   =   $(this);
        var $items  =   $self.find('.items > .item');
        var $dots   =   $self.find('.dots > .dot');
        var rsi;
        
        
        // ротация баннеров
        
        var makeRotation = function()
        {
            if ( !options )             return;
            if ( !options.rotate )      return;
            if ( $dots.length < 2 )     return;
            if ( rsi != undefined )     clearInterval(rsi);
            
            
            rsi  =  setInterval(function(){
                $self.find('.nav.next').click();
            }, options.rotate );
        }
        
        
        
        
        // навигация
        
        $(this).find('.nav').click(function(){
            $t = $(this);
            if ( $t.hasClass('next') )  next();
            if ( $t.hasClass('prev') )  prev();
            if ( $t.hasClass('dot') )   dot($t);
        });
        

        var dot = function($t)
        {
            var length  =   $t.prevAll().length;
            
            $items.removeClass('active');
            $($items[length]).addClass('active');

            $dots.removeClass('active');
            $($dots[length]).addClass('active');
            
            makeRotation();
        };
        

        var next = function()
        {
            var $t =    $self.find('.item.active');
            $t.removeClass('active');
            
            var $n  =   $t.next('.item');
            if ( $n.length > 0 )
            {
                $n.addClass('active');
            } else {
                $t.prevAll('.item').last().addClass('active');
            }
            
            dotActive();
        };
        
        
        var prev = function()
        {
            var $t =    $self.find('.item.active');
            $t.removeClass('active');
            
            var $n  =   $t.prev('.item');
            if ( $n.length > 0 ) {
                $n.addClass('active');
            } else {
                $t.nextAll('.item').last().addClass('active');
            }
            
            dotActive();
        }


        var dotActive = function()
        {
            if( $dots.length < 2 )
            {
                $self.find('.nav').css('display', 'none');
            }
            
            var length  =   $self.find('.item.active').first().prevAll().length;
            
            $dots.removeClass('active');
            $($dots[length]).addClass('active');
            
            
            makeRotation();
        };
        
        
        dotActive();
        
        
        
        
        
        
        
        // свайп
        
        $(this).swipe({
            preventDefaultEvents: !/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent),
            threshold: 45,
            swipe:function(event, direction) {
                
                if (  $dots.length < 2 )    return;
                
                if (direction == 'left')        next();
                else if (direction == 'right')  prev();
                
                if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) == false)
                {
                    event.target.onclick = function(e) {
                        e.preventDefault();
                        this.onclick = false;
                    }
                }
                
            }
        })
        
                
      };
    })( jQuery );