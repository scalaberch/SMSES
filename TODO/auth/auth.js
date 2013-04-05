$(function () {

	$('#error-message-manager').hide(0);

	$('#manager-login')
		.click(function () { $('#manager-login-form').dialog('open'); });
		
	$('#attendant-login')
		.click(function () { $('#attendant-login-form').dialog('open'); });
		
	$('#attendant-login-password')
		.click(function () { $('#attendant-login-password-form').dialog('open'); });
		
	$('#user-name-field')
		.focus(function () {
			$(this).css('color', 'black');
			
		})
		.blur(function () {
			if ($(this).val() == ""){
				$(this).val("User Name");
				$(this).css('color', 'grey');
			}
		});
		
	$('#password-field')
		.focus(function () {
			$(this).val("");
			this.type = "password";
			$(this).css('color', 'black');
			
		})
		.blur(function () {
			if ($(this).val() == ""){
				$(this).val("Password");
				$(this).css('color', 'grey');
				this.type = "text";
			}
		});
		
	$('.login-form')
		.dialog({
			autoOpen:false,
			modal:true,
			show:"drop", hide: "drop",
			draggable:false, resizable:false
		});
		
	$('#auth-button, .button').button();
	
	$('#auth-button')
		.click( function () {
			//Get Manager Details
			var username = $('#user-name-field').val(),
				password = $('#password-field').val();
				
			var isSuccess = "";
				
			$.ajax({
				url: "auth.php",
				type: "POST",
				datatype:"html",
				data:{
					user-name:username, 
					pass-word:password
				}, 
				success: function (data) {
					isSuccess = data;
				}
			});	
			
			if (isSuccess == "true"){
				window.open('/SMSES/', '_self');
			}
			else {
				$('#error-message-manager').show(1000);
			}
			
		});
	
		
});