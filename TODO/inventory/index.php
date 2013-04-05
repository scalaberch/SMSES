<html>
<head>
	<title> SMSES - Inventory </title>
	
	<link rel="stylesheet" href="../lib/css/style.css" type="text/css" />
	<script type='text/javascript' src='../lib/jqueryUI/js/jquery-1.6.2.min.js'></script>
	<link type='text/css' href='../lib/jqueryUI/css/custom-theme/jquery-ui-1.8.16.custom.css' rel='stylesheet'/>	
	<script type='text/javascript' src='../lib/jqueryUI/js/jquery-ui-1.8.16.custom.min.js'></script>
	<script type='text/javascript' src='auth.js'></script>
	
</head>
<body>
	<div id='header'>
		<div id='left-header'>
			<ul><li id='location' class='text'>Inventory Sub Menu</li></ul>
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
	<div id='sub-menu' align='center'>
		<div id='menu' align='left'>
			<ul>
				<li>
					<a href='search.php'><img src='../lib/img/small/search.png' style='float:left;margin-right:8px;'/></a>
					Search for an Item 
				</li>
				<li>
					<a href='manage_inv.php'><img src='../lib/img/small/manage-inventory.png' style='float:left;margin-right:8px;'/></a>
					Manage Inventory 
				</li>
				<li>
					<a href='manage_sup.php'><img src='../lib/img/small/supplier.png' style='float:left;margin-right:8px;'/></a>
					Manage Suppliers
				</li>
				<li> 
					<a href='../index.php'><img src='../lib/img/small/back.png' style='float:left;margin-right:8px;'/></a>
					Go back to Dashboard
				</li>
			</ul>
		</div>
		<div id='sub-menu-text' align='left'>
			<img src='../lib/img/icon/inv.png' style='float:left'/>
				<div class='sub-menu-text-main'>
					inventory
				</div>
				inventory management sub-menu				
		</div>
	</div>
	
	
	
</body>
</html>