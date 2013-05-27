$(document).ready(function() {
	$('#myForm').submit(function() {
		$('.error').remove();
		var hasError = false;
		$('.required').each(function() {
			if(jQuery.trim($(this).val()) == '') {
				var labelText = $(this).prev('label').text();
				$(this).parent().append('<span class="error">&raquo; You forgot to enter your '+labelText+'.</span>');
				hasError = true;
			} else if($(this).hasClass('email')) {
				var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
				if(!emailReg.test(jQuery.trim($(this).val()))) {
					var labelText = $(this).prev('label').text();
					$(this).parent().append('<span class="error">&raquo; You entered an invalid '+labelText+'.</span>');
					hasError = true;
				}
			}
		});
		if(!hasError) {
			return true;
		}
		
		return false;
		
	});
});