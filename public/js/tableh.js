(function($) {

	var settings = {
		
		'sort': 'asc'
	}
	
	function removeSort() {
		
		$('.asc').removeClass('asc');
		$('.desc').removeClass('desc');
	}
	
	var methods = {
		
		init: function (options) { 
		
			if (options) {
				
				$.extend(settings, options);
				console.log(options);
			}		
			
			return this.each(function() {
				
				var $this = $(this);
				
				$(this).find('th').css('cursor', 'pointer');
				
				$(this).find('th').click(function () {
				
					if ($(this).children('.sort').hasClass('asc')) {
						
						removeSort();
						$(this).children('.sort').addClass('desc');
					}
					else {
						
						removeSort();
						$(this).children('.sort').addClass('asc');
					}
				});
			});	
		}
	};

	$.fn.tableh = function (method) {

		if (methods[method]) {
			
	    	return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
	    } 
		else if (typeof method === 'object' || !method) {
			
	      	return methods.init.apply(this, arguments);
	    } 
		else {
	      	
			$.error('Method ' +  method + ' does not exist on jQuery.tableh');
	    }    
 	};
})(jQuery);