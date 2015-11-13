(function($){
    $.fn.blink = function(options){
        var defaults = {
            delay:500
        };
        var options = $.extend(defaults, options);
		
        return this.each(function(){
            var obj = $(this);
            setInterval(function(){
                if($(obj).css("color") == "rgb(166, 11, 7)"){
                    $(obj).css('color','#6EA100');
                }
                else if($(obj).css("color") == "rgb(110, 161, 0)"){
                    $(obj).css('color','#0091CD');
                }else{
                    $(obj).css('color','#A60B07');
                }
            }, options.delay);
        });
    }
}(jQuery))