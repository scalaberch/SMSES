<?php
include "../lib/ProjectLibrary.php";
session_start();

/* Cash Register Utilities... */
if (isset($_GET['setNewReceipt'])){
	$_SESSION['receipt'] = new Receipt();
	if (isset($_SESSION['receipt'])){
		echo "true";
	}
}
else if (isset($_GET['cancelReceipt'])){
	unset($_SESSION['receipt']);
	if (!isset($_SESSION['receipt'])){
		echo "true";
	}
}
else if (isset($_GET['hasTransaction'])){
	if (isset($_SESSION['receipt'])){
		echo "true";
	}
}
else if (isset($_GET['checkIfItemisInDB'])){
	$item = $_POST['item'];
	$connection = new DatabaseConnection();
	$itemchecker = new Item($item);
	if ($itemchecker->is_item_in_database($item)){
		echo "true";
	}
	mysql_close($connection->connection);
}
else if (isset($_GET['getItemInfo'])){
	$item = $_GET['item'];
	$connection = new DatabaseConnection();
	$itemdata = new Item($item);
	$itementry = new ItemEntry($item);
	
	$json = '{"name":"'.$itemdata->getName().'", 
				"description":"'.$itemdata->getDescription().'",
				"price":"'.$itementry->getQuantity().'" }';
	
	echo $json;
	mysql_close($connection->connection);
}




?>