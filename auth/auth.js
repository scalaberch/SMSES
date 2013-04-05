$(function () {

	$('#error-message-manager').hide(0);

	
	$('#close-nobody')
		.click(function () { $('#attendant-login-form').dialog('close'); } );
		
	$('#attendant-login-password')
		.click(function () { $('#attendant-login-password-form').dialog('open'); });
		
	$('#user-name-field')
		.focus(function () {
			$(this).css('color', 'black');
			$(this).val("");
		})
		.blur(function () {
			if ($(this).val() == ""){
				$(this).val("User Name");
				$(this).css('color', 'grey');
			}
		});
		
		
	$('#authenticate-button')
		.click(function () {
			var username = $('#user-name-field').val(),
				password = $('#password-field').val();
			if (username == "" || username == "Enter your employee ID here..." || username == "User Name"){
				$('#error-message-manager').show('fade', 500);
				setTimeout( function () { $('#error-message-manager').hide('fade', 500); }, 3000);
			}
			else if (password == "" || password == "Password"){
				$('#error-message-manager').html("Please enter a password.");
				$('#error-message-manager').show('fade', 500);
				setTimeout( function () { $('#error-message-manager').hide('fade', 500);
					$('#error-message-manager').html("Please enter a username.");
				}, 3000);
			}
			else {
				$.ajax({
					url: "auth.php?verifyUser",
					type: "POST",
					datatype:"html",
					data:{
						userName:username,
						passWord:password
					}, 
					success: function (data) {
						if (data == "true"){
							//command_fill_authentication_form();
							//check if assigned here...
							$.ajax({
								url: "auth.php?checkIfAssigned",
								type: "POST", datatype:"html",
								data: { userName:username },
								success: function (data){
									var locloc = "";
									if (data == "true"){
										//go to authSucess
										$.ajax({
											url: "auth.php?authSucess",
											type:"POST",
											data: { userName:username },
											success: function (){
												window.open('../', '_self');
											}
										});
									}
									else {
										//go to authFail
										$.ajax({
											url: "auth.php?authFail",
											type:"POST", datatype:"html",
											data: { userName:username },
											success: function (data){
												$('#authentication-form').dialog('open');
												setTimeout(function () {
													$('#authentication-form').html(data);
												}, 1000);
											}
										});
									}
								}
							});
						}
						else {
							$('#error-message-manager').html("Employee ID / Password mismatch. Please try again.");
							$('#error-message-manager').show('fade', 500);
							setTimeout( function () { $('#error-message-manager').hide('fade', 500);
								$('#error-message-manager').html("Please enter a username.");
							}, 3000);
						}
					}
				});
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
			modal:true, width:405,
			show:"drop", hide: "drop",
			draggable:false, resizable:false,
			close: function () {
				$('#error-message-manager').hide(50);
			}
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
					userName:username, 
					passWord:password
				}, 
				success: function (data) {
					
					if (data == "true"){
						window.open('/SMSES/', '_self');
					}
					else {
						$('#error-message-manager').show(300);
					}
				}
			});	
			
		});
		
	/* Setter */
	$('#login-main-content').show('clip', 1000);
		
});

function command_fill_authentication_form(){
	var username = $('#user-name-field').val();
	$('#authentication-form').dialog('open');
	$.ajax({
		url: "auth.php?fillAuthenticateUser",
		type: "POST",
		datatype:"html",
		data:{
			userName:username
		}, 
		success: function (data) {
			$('#authentication-form').html("");
			setTimeout(function () {
				$('#loading').hide('fade', 500);
			}, 500);
			setTimeout(function () {
				$('#authentication-form').append(data);
			}, 1000);
		}	
	});
}

function append_password_settings(){
	$('#error-password-manager').hide(0);
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
		
	$('#login-button')
		.button()
		.click(function () {
			var username = $('#user-name-field').val(),
				password = $('#password-field').val();
				
			$.ajax({
				url: "auth.php?authenticateUser",
				type: "POST",
				datatype:"html",
				data:{ userName:username, passWord:password }, 
				success: function (data) {
					if (data == "true"){
						window.open('/SMSES', '_self');
					}
					else {
						$('#error-password-manager').show('fade', 500);
						setTimeout(
							function () {
								$('#error-password-manager').hide('fade', 500);
							}, 3000
						);
					}
				}	
			});
		}
	);
}