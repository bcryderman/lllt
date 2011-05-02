(function($) {

	var settings = {
		
		'sort': 'asc'
	}
	
	function removeSort() {
		
		$('.asc').removeClass('asc');
		$('.desc').removeClass('desc');
	}
	
	function returnSortedData(obj, column, sort) {
		
		$.post(settings.url + '/column/' + column + '/sort/' + sort, function(data) {
			
			var data = $(data);
			
			data.children('tr:even').css('background-color', '#cef6e3');
			obj.children('tbody').replaceWith(data);			
		});
	}
	
	var methods = {
		
		init: function (options) { 
		
			if (options) {
				
				$.extend(settings, options);
			}		
			
			return this.each(function() {
				
				var $this = $(this);
				
				$(this).find('th:not(.edit):not(.delete)').css('cursor', 'pointer');
				
				$(this).find('th:not(.edit):not(.delete)').click(function () {
				
					if ($(this).children('.sort').hasClass('asc')) {
						
						var sortMethod = 'desc';
					}
					else {
						
						var sortMethod = 'asc';
					}
					
					removeSort();
					$(this).children('.sort').addClass(sortMethod);
					returnSortedData($this, $(this).attr('column'), sortMethod);
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
}) (jQuery);