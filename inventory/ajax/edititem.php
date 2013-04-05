<?php
	include "C:/wamp/www/SMSES/lib/ProjectLibrary.php";
	session_start();
	
	//Start DB Connection
	$connection = new DatabaseConnection();

	if (isset($_GET['checkIfIDisOK'])){
		$id = $_POST['id'];
		$query = mysql_query("SELECT * FROM item WHERE itemID=$id ");
		while($result = mysql_fetch_array($query)){
			if ($id == $result['itemID']){
				echo "true";
			}
		}
	}
	else if (isset($_GET['edit'])){
		$id = $_POST['id'];
		$query = "UPDATE item SET 
					itemName='".$_POST['name']."',
					itemDescription='".$_POST['desc']."',
					supplierID='".$_POST['supp']."',
					categoryID='".$_POST['cat']."'
				  WHERE itemID=$id";
		mysql_query($query);
	}
	
	
	mysql_close($connection->connection);
?>