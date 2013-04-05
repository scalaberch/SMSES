<html>
<head>
	<title> SMSES - Log In </title>
	
	<link rel="stylesheet" href="../lib/css/style.css" type="text/css" />
	<script type='text/javascript' src='../lib/jqueryUI/js/jquery-1.6.2.min.js'></script>
	<link type='text/css' href='../lib/jqueryUI/css/custom-theme/jquery-ui-1.8.16.custom.css' rel='stylesheet'/>	
	<script type='text/javascript' src='../lib/jqueryUI/js/jquery-ui-1.8.16.custom.min.js'></script>
	<script type='text/javascript' src='auth.js'></script>
	
</head>
<body>
	<div id='header'>
		<div id='left-header'>
			<ul><li id='location' class='text'>Login Screen</li></ul>
		</div>
		<div id='right-header'>
			<ul>
				<li><img src='../lib/img/icon/clock.png' /></li>
				<li class='text'>
					<span id='myclock'></span>
				</li>
				<!-- 
				<li><img src='../lib/img/icon/user.png' /></li>
				<li class='text'>scalaberch</li>
				
				<li>
					<a href='auth/logout.php'><img src='../lib/img/icon/out.png' /></a>
				</li> -->
			</ul>
		</div>
	</div>

	<div id='login'>
		<div id='login-main-text'>
			Login Screen
		</div>
		<div id='login-main-content'>
			<ul>
				<li id='manager-login'> Manager/Supervisor Login </li>
				<li id='attendant-login'> Attendant/Cashier Login </li>
			</ul>
		</div>
	</div>
	
	<!-- Manager Login Form -->
	
	<div id='manager-login-form' class='login-form' title='Manager/Supervisor Login Form'>
		<div>
			<input type='text' id='user-name-field' class='login-form-field' value='User Name' /><br />
			<input type='text' id='password-field' class='login-form-field' value='Password' /><br />
			<div id='error-message-manager' class="ui-state-error ui-corner-all" style="padding: 0 .7em;"> 
				<p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span> 
				<strong>Error:</strong> Please check your username/password.</p>
			</div>
			<input type='button' id='auth-button' value='Log In!' />
		</div>
	</div>
	
	<!-- Attendant Login Form -->
	
	<div id='attendant-login-form' class='login-form' title='Attendant/Cashier Login Form'>
		<div>
			<?php
				$occupied = true; $user = "<i>Scrappy Coco</i>";
				if ($occupied){
					echo "This computer is currently assigned to: $user . If you are not
							$user, then please proceed to your manager to have an 
							access in a workstation. Otherwise, please click the login
							button.
							<br /><br />
							";
					
					echo "<input type='button' id='attendant-login-password' value='Log In' style='width:100%;' class='button'/>";
				}
				else {
					echo "Nobody is assigned to this computer. Please 
							consult your respective supervisor for your login purposes.";
				}
			?>
		</div>
	</div>
	
	<div id='attendant-login-password-form' class='login-form' title='Enter Current User Password'>
	
		Please enter <?php echo $user; ?>'s  password:<br /> 
		<input type='password' style='width:99%;' /> 
		<input type='button' style='width:99%;' class='button' value='Log In!' />
	
	</div>
	
	
</body>
</html>