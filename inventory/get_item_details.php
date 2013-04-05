<?php
	
	include "../lib/ProjectLibrary.php";
	
	$connection = new DatabaseConnection();

	$json = "";
	if (isset($_GET['fromItemName'])){
		$item = $_GET['fromItemName'];
		$query = "SELECT itemID, itemName, itemDescription FROM item WHERE itemName='$item'";
		$query_result = mysql_query($query);
		while($result = mysql_fetch_array($query_result)){
			$json = '{"id":"'.$result['itemID'].'",
					  "name":"'.$result['itemName'].'",
					  "description":"'.$result['itemDescription'].'"}';
				
		}
		
		echo $json;
		
	
	}


?>