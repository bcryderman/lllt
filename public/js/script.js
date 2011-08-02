$(function() {
	
	$('input:button, input:submit').button();	
	$('ul.sf-menu').superfish(); 
	$('.numeric').numeric();
	$('.decimal').numeric({ allow: '.' });
	$('table tr:odd').css('background-color', '#cef6e3');
	$('.phone').mask('(999) 999-9999');
	$('.datepicker').mask('99/99/9999').datepicker();
	$('.timepicker').mask('99:99').timepicker();
	$('.no-color tr:odd').css('background-color','#FFFFFF');
	
});

//var emailRegEx = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;

$(document).ready(function() {
		
	$('.timepicker2').click(function(){$(this).val(timepick());});
});

function timepick(){
	now = new Date();
	  hours = now.getHours();
	  min = now.getMinutes();
	  sec = now.getSeconds();


	    if (min <= 9) {
	      min = "0" + min;
	    }
	    if (sec <= 9) {
	      sec = "0" + sec;
	    }
	    if (hours > 12) {
	      hours = hours - 12;
	      merridan = "PM";
	    } else {
	      hours = hours;
	      add = "AM";
	    }
	    if (hours == 12) {
	    	merridan = "PM";
	    }
	    if (hours == 00) {
	      hours = "12";
	    }
	return hours +':' + min + ' ' + merridan ;
}
