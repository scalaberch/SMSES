<?php
	include "../lib/ProjectLibrary.php";
	session_start();
	
	$utility = new Utility();
	
	if (isset($_GET['logout'])){
		$con = new DatabaseConnection();
		$myip = getenv("REMOTE_ADDR");
		$query = "UPDATE computer SET computerUser='' WHERE computerIPAddress='$myip' ";
		mysql_query($query);
		
		session_destroy();
		mysql_close($con->connection);
		$utility->redirect('/SMSES/auth/');
	}
	else if (isset($_SESSION['user'])){
		$utility->redirect('/SMSES');
	}

?>
<html>
<head>
	<title> SMSES - Log In </title>
	
	<link rel="stylesheet" href="../lib/css/style.css" type="text/css" />
	
	<script type='text/javascript' src='../lib/jqueryUI/js/jquery-1.7.1.min.js'></script>
	<link type='text/css' href='../lib/jqueryUI/css/custom-theme/jquery-ui-1.8.18.custom.css' rel='stylesheet'/>	
	<script type='text/javascript' src='../lib/jqueryUI/js/jquery-ui-1.8.18.custom.min.js'></script>
	<script type='text/javascript' src='auth.js'></script>
	
</head>
<body>
	<div id='header'>
		<div id='left-header'>
			<ul><li id='location' class='text'>Login Screen</li></ul>
		</div>
		<script type='text/javascript' src='../lib/js/topbar.js'></script>
		<div id='right-header'>
			<ul>
				<li><img src='../lib/img/icon/clock.png' /></li>
				<li class='text'>
					<span id='myclock'></span>
				</li>
			</ul>
		</div>
	</div>

	<div id='login'>
		
		<div id='login-main-content'>
			<div id='login-main-text'>
			Login Screen
			</div>
			<div id='login-content'>
				Please enter your employee ID to continue. <br />
				<input type='text' id='user-name-field' value='Enter your employee ID here...' style='width:100%;margin-top:5%;color:grey;'/>
				<input type='text' id='password-field' value='Password' style='width:100%;color:grey;'/>
					<div id='error-message-manager' class="ui-state-error ui-corner-all" align='center' style="padding:0.7 em;color:red;"> 
						Please enter a username.
					</div>
				<input type='button' id='authenticate-button' class='button' style='width:100%;margin-top:2%;' value='Authenticate User' />
				
			</div>
		</div>
	</div>
	
	<!-- Manager Login Form -->
	
	<div id='authentication-form' class='login-form' title='Authenticating User...'>
		<div id='loading' align='center'>
			<br />
			<img src='../lib/img/load.gif' />
		</div>
	</div>
	
</body>
</html>