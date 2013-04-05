<?php
	include "lib/ProjectLibrary.php";
	session_start();
	
	$utility = new Utility();
	
	if (!isset($_SESSION['user'])){
		$utility->redirect('/SMSES/auth');
	}

?>
<html>
<head>
	<title> SMSES </title>
	
	<link rel="stylesheet" href="lib/css/style.css" type="text/css" />
	<script type='text/javascript' src='lib/jqueryUI/js/jquery-1.7.1.min.js'></script>
	<link type='text/css' href='lib/jqueryUI/css/custom-theme/jquery-ui-1.8.18.custom.css' rel='stylesheet'/>	
	<script type='text/javascript' src='lib/jqueryUI/js/jquery-ui-1.8.18.custom.min.js'></script>
<!--<script type='text/javascript' src='auth.js'></script> -->
<script type='text/javascript'>
	$.ajax({ url:"sessionteller.php?position", datatype: "html",
		success: function (data) {
			if (data == 'Attendant' || data == 'Supervisor'){
				if(data == 'Attendant'){
					$('#main-menu-reports').remove();
					$('#main-menu-others').remove();
				}
				$('#main-menu-finance').remove();
			}
			else{
				if(data == 'Cashier'){
					$('#main-menu-reports').remove();
					$('#main-menu-others').remove();
				}
				$('#main-menu-inventory').remove();
			}
		}
	});
</script>
</head>
<body>
<div id='header'>
		<div id='left-header'>
			<ul><li id='location' class='text'>Main Menu</li></ul>
		</div>
<?php
	include_once "sidebar-main.php";
?>
	<div id='menu' align='center'>
		<div id='main-menu' align='left'>
			<ul>
				<li id='main-menu-inventory' class='main-menu-buttons'>
					<div class='main-menu-buttons-image'>
						<a href='inventory/'><img src='lib/img/icon/inv.png' style='float:left'/>
						<div class='main-menu-buttons-text'>
							inventory
						</div>
						click here to show the inventory functionalities
						</a>
					</div>
				</li>
				<li id='main-menu-finance' class='main-menu-buttons'>
					<div class='main-menu-buttons-image'>
						<a href='finance/'><img src='lib/img/icon/financial.png' style='float:left'/>
						<div class='main-menu-buttons-text'>
							finance
						</div>
						click here to show all financial functionalities
						</a>
					</div>
				</li>
				<li id='main-menu-reports' class='main-menu-buttons'>
					<div class='main-menu-buttons-image'>
						<a href='reports/'><img src='lib/img/icon/reports.png' style='float:left'/>
						<div class='main-menu-buttons-text'>
							reports
						</div>
						click here to generate reports for the shop
						</a>
					</div>
				</li>
				<li id='main-menu-others' class='main-menu-buttons'>
					<div class='main-menu-buttons-image'>
						<a href='others/'><img src='lib/img/icon/others.png' style='float:left'/>
						<div class='main-menu-buttons-text'>
							others
						</div>
						click here to show other system functions
						</a>
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