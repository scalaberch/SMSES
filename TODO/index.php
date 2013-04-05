<html>
<head>
	<title> SMSES - Log In </title>
	
	<link rel="stylesheet" href="lib/css/style.css" type="text/css" />
	<script type='text/javascript' src='lib/jqueryUI/js/jquery-1.6.2.min.js'></script>
	<link type='text/css' href='lib/jqueryUI/css/custom-theme/jquery-ui-1.8.16.custom.css' rel='stylesheet'/>	
	<script type='text/javascript' src='lib/jqueryUI/js/jquery-ui-1.8.16.custom.min.js'></script>
	<script type='text/javascript' src='auth.js'></script>
	
</head>
<body>
	<div id='header'>
		<div id='left-header'>
			<ul><li id='location' class='text'>Main Menu</li></ul>
		</div>
		<div id='right-header'>
			<ul>
				<li><img src='lib/img/icon/clock.png' /></li>
				<li class='text'>
					<span id='myclock'></span>
				</li> 
				<li><img src='lib/img/icon/user.png' /></li>
				<li class='text'>scalaberch</li>
				
				<li>
					<a href='auth/logout.php'><img src='lib/img/icon/out.png' /></a>
				</li>
			</ul>
		</div>
	</div>
	<div id='menu' align='center'>
		<div id='main-menu' align='left'>
			<ul>
				<li id='main-menu-inventory' class='main-menu-buttons'>
					<div class='main-menu-buttons-image'>
						<a href='inventory/'><img src='lib/img/icon/inv.png' style='float:left'/></a>
						<div class='main-menu-buttons-text'>
							inventory
						</div>
						click here to show the inventory functionalities
					</div>
				</li>
				<li id='main-menu-finance' class='main-menu-buttons'>
					<div class='main-menu-buttons-image'>
						<a href='finance/index.php'><img src='lib/img/icon/financial.png' style='float:left'/></a>
						<div class='main-menu-buttons-text'>
							finance
						</div>
						click here to show all financial functionalities
					</div>
				</li>
				<li id='main-menu-reports' class='main-menu-buttons'>
					<div class='main-menu-buttons-image'>
						<a href='reports/index.php'><img src='lib/img/icon/reports.png' style='float:left'/></a>
						<div class='main-menu-buttons-text'>
							reports
						</div>
						click here to generate reports for the shop
					</div>
				</li>
				<li id='main-menu-others' class='main-menu-buttons'>
					<div class='main-menu-buttons-image'>
						<a href='others/index.php'><img src='lib/img/icon/others.png' style='float:left'/></a>
						<div class='main-menu-buttons-text'>
							others
						</div>
						click here to show other system functions
					</div>
				</li>
			</ul>
		</div>
		<div id='main-menu-text' align='left'>
			<div id='main-menu-text-head'>main menu</div>
			supply monitoring system for an electrical shop
		</div>
	</div>
	
	
	
</body>
</html>