<html>
<head>
	<title> SMSES </title>
	
	<link rel="stylesheet" href="../lib/css/style.css" type="text/css" />
	<script type='text/javascript' src='../lib/jqueryUI/js/jquery-1.7.1.min.js'></script>
	<link type='text/css' href='../lib/jqueryUI/css/custom-theme/jquery-ui-1.8.18.custom.css' rel='stylesheet'/>	
	<script type='text/javascript' src='../lib/jqueryUI/js/jquery-ui-1.8.18.custom.min.js'></script>
	<script type='text/javascript' src='js/main.js'></script>
	
</head>
<body>
	<div id='header'>
		<div id='left-header'>
			<ul><li id='location' class='text'>Financial Module</li></ul>
		</div>
		<div id='right-header'>
			<ul>
				<li><img src='../lib/img/icon/clock.png' /></li>
				<li class='text'>
					<span id='myclock'></span>
				</li> 
				<li><img src='../lib/img/icon/user.png' /></li>
				<li class='text'>scalaberch</li>
				
				<li>
					<a href='auth/logout.php'><img src='../lib/img/icon/out.png' /></a>
				</li>
			</ul>
		</div>
	</div>
	<?php
	
		if (isset($_GET['register'])){
			include "search.php";
		}
		else if (isset($_GET['forecast'])){
			include "forecast.php";
		}
		else {
			include "default.php";
		}
	
	
	
	?>
	
</body>
</html>