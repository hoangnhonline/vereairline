;(function($){

	$.fn.advScroll = function(option) {
		$.fn.advScroll.option = {
			marginTop:20,
			easing:'',
			timer:400,
		};

		option = $.extend({}, $.fn.advScroll.option, option);

		return this.each(function(){
			var el = $(this);
			$(window).scroll(function(){
				t = parseInt($(window).scrollTop()) + option.marginTop;
				el.stop().animate({top:t},option.timer,option.easing);
			})
		});
	};

})(jQuery)