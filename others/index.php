<?php
	include "../lib/ProjectLibrary.php";
	session_start();
	
	$utility = new Utility();
	
	if (!isset($_SESSION['user'])){
		$utility->redirect('/SMSES/auth');
	}
?>
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
			<ul><li id='location' class='text'>Other Functionalities</li></ul>
		</div>
		<?php
		include "../sidebar.php";
		?>
	</div>
	<?php
	
		if (isset($_GET['finance'])){
			include "finance.php";
		}
		else if (isset($_GET['assign'])){
			include "assign.php";
		}
		else if (isset($_GET['inventory'])){
			include "inventory.php";
		}
		else {
			include "default.php";
		}
	
	
	
	?>
	
</body>
</html>