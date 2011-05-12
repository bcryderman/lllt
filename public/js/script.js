$(function() {
	
	$('input:button, input:submit').button();	
	$('ul.sf-menu').superfish(); 
	$('.numeric').numeric();
	$('.decimal').numeric({ allow: '.' });
	$('table tr:odd').css('background-color', '#cef6e3');
	$('.phone').mask('(999) 999-9999');
	$('.datepicker').mask('99/99/9999').datepicker();
	$('.timepicker').mask('99:99').timepicker();
});

//var emailRegEx = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;

$(document).ready(function() {
		
	
});
