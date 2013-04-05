<?php
include "../lib/ProjectLibrary.php";
$connection = new DatabaseConnection();

$item = null;
if (isset($_POST['itemID'])){
	$item = $_POST['itemID'];
}

if (isset($_GET['activate'])){
	$query = "UPDATE item SET itemStatus='GOOD' WHERE itemID='$item'";
	echo $_POST['itemID'];
	mysql_query($query);
}
else if (isset($_GET['deactivate'])){
	$query = "UPDATE item SET itemStatus='DEACTIVATED' WHERE itemID='$item'";
	mysql_query($query);
}

mysql_close($connection->connection);


?>