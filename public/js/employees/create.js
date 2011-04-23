$(function() {
	
	$('#username').focus();
});

$(document).ready(function() {
	
	$('#show-hide-comm-options').toggle(function() {
		
		$(this).html('- Communication Options');
		$('#comm-options').show();
	}, function() {
		
		$(this).html('+ Communication Options');
		$('#comm-options').hide();
	});
	
	$('#createemp-form').submit(function(e) {
		
		$('.error-header').remove();
		
		var errors = false;
		
		if ($('#username').val().length === 0) {
			
			errors = true;
			
			if (!$('#username').hasClass('required-error')) {
				
				$('#username').addClass('required-error');
			}	
		}
		else {
			
			if ($('#username').hasClass('required-error')) {
				
				$('#username').removeClass('required-error');
			}
		}
		
		if ($('#password').val().length === 0 || ($('#password').val() !== $('#confpass').val())) {
			
			errors = true;
			
			if (!$('#password').hasClass('required-error')) {
				
				$('#password').addClass('required-error');
			}
		}
		else {
			
			if ($('#password').hasClass('required-error')) {
				
				$('#password').removeClass('required-error');
			}
		}
		
		if ($('#confpass').val().length === 0 || ($('#password').val() !== $('#confpass').val())) {
			
			errors = true;
			
			if (!$('#confpass').hasClass('required-error')) {
				
				$('#confpass').addClass('required-error');
			}
		}
		else {
			
			if ($('#confpass').hasClass('required-error')) {
				
				$('#confpass').removeClass('required-error');
			}
		}
		
		if ($('#first_name').val().length === 0) {
			
			errors = true;
			
			if (!$('#first_name').hasClass('required-error')) {
				
				$('#first_name').addClass('required-error');
			}	
		}
		else {
			
			if ($('#first_name').hasClass('required-error')) {
				
				$('#first_name').removeClass('required-error');
			}
		}
		
		if ($('#last_name').val().length === 0) {
			
			errors = true;
			
			if (!$('#last_name').hasClass('required-error')) {
				
				$('#last_name').addClass('required-error');
			}	
		}
		else {
			
			if ($('#last_name').hasClass('required-error')) {
				
				$('#last_name').removeClass('required-error');
			}
		}
		
		if ($('#email').val().length > 0 && !emailRegEx.test($('#email').val())) {
			
			errors = true;
			
			if (!$('#email').hasClass('error')) {
				
				$('#email').addClass('error');
			}	
        }
		else {
			
			if ($('#email').hasClass('error')) {
				
				$('#email').removeClass('error');
			}
		}
		
		if ($('#zip').val().length > 0 && $('#zip').val().length !== 5) {
			
			errors = true;
			
			if (!$('#zip').hasClass('error')) {
				
				$('#zip').addClass('error');
			}	
		}
		else {
			
			if ($('#zip').hasClass('error')) {
				
				$('#zip').removeClass('error');
			}
		}
		
		if ($('#zip4').val().length > 0 && $('#zip4').val().length !== 4) {
			
			errors = true;
			
			if (!$('#zip4').hasClass('error')) {
				
				$('#zip4').addClass('error');
			}	
		}
		else {
			
			if ($('#zip4').hasClass('error')) {
				
				$('#zip4').removeClass('error');
			}
		}
		
		if ($('#role_id').val().length === 0) {
			
			errors = true;
			
			if (!$('#role_id').hasClass('required-error')) {
				
				$('#role_id').addClass('required-error');
			}
		}
		else {
			
			if ($('#role_id').hasClass('required-error')) {
				
				$('#role_id').removeClass('required-error');
			}
		}
		
		if ($('#user_type_id').val().length === 0) {
			
			errors = true;
			
			if (!$('#user_type_id').hasClass('required-error')) {
				
				$('#user_type_id').addClass('required-error');
			}
		}
		else {
			
			if ($('#user_type_id').hasClass('required-error')) {
				
				$('#user_type_id').removeClass('required-error');
			}
		}
		
		if ($('#phone_ext').val().length > 0 && $('#phone').val().length === 0) {
			
			errors = true;
			
			if (!$('#phone').hasClass('error')) {
				
				$('#phone').addClass('error');
			}
		}
		else {
			
			if ($('#phone').hasClass('error')) {
				
				$('#phone').removeClass('error');
			}
		}
		
		if ($('#phone').val().length > 0 && $('#cell_phone').val().length === 0 && $('#phone_primary').is(':not(:checked))')) {
			
			$('#phone_primary').attr('checked', true);
		}
		
		if ($('#cell_phone').val().length > 0 && $('#phone').val().length === 0 && $('#cell_phone_primary').is(':not(:checked))')) {
			
			$('#cell_phone_primary').attr('checked', true);
		}
		
		if ($('#communication_type_id').val().length === 0 && $('#cell_phone').val().length > 0) {
			
			errors = true;
			
			if (!$('#communication_type_id').hasClass('error')) {
				
				$('#communication_type_id').addClass('error');
			}
		}
		else {
			
			if ($('#communication_type_id').hasClass('error')) {
				
				$('#communication_type_id').removeClass('error');
			}
		}
		
		if ($('#communication_type_id').val().length > 0 && $('#cell_phone').val().length === 0) {
			
			errors = true;
			
			if (!$('#cell_phone').hasClass('error')) {
				
				$('#cell_phone').addClass('error');
			}
		}
		else {
			
			if ($('#cell_phone').hasClass('error')) {
				
				$('#cell_phone').removeClass('error');
			}
		}
				
		if (errors) {
			
			e.preventDefault();
		}
	});
	
	$('#phone').bind('blur keyup', function() {
		
		if ($(this).val().length === 0) {
			
			$('#phone_primary').attr({ 'checked': false, 'disabled': true });			
		}
		else {
			
			$('#phone_primary').removeAttr('disabled');
		}		
	});
	
	$('#phone_primary').click(function() {
		
		if ($('#cell_phone_primary').is(':checked')) {
			
			$('#cell_phone_primary').attr('checked', false);
		}
	});
	
	$('#cell_phone').bind('blur keyup', function() {
		
		if ($(this).val().length === 0) {
			
			$('#cell_phone_primary').attr({ 'checked': false, 'disabled': true });			
		}
		else {
			
			$('#cell_phone_primary').removeAttr('disabled');
		}		
	});
	
	$('#cell_phone_primary').click(function() {
		
		if ($('#phone_primary').is(':checked')) {
			
			$('#phone_primary').attr('checked', false);
		}
	});
});