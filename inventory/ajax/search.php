<?php
include "C:/wamp/www/SMSES/lib/ProjectLibrary.php";
session_start();

//
//
//
//

$connection = new DatabaseConnection();

//echo '[{"value":"Hanabishi HRC-10SS Rice Cookerrrr"},{"value":"Item Ni SIYA"},{"value":"Junction Box"},{"value":"Xtra Strong Electrical Bicycle"}]';
if (isset($_GET['set'])){
	
	$_SESSION['searchtype'] = $_POST['setting'];
	//echo $_SESSION['searchtype'];
}
else {
//echo '[{"value":"Hanabishi HRC-10SS Rice Cookerrrr"},{"value":"Item Ni SIYA"},{"value":"Junction Box"},{"value":"Xtra Strong Electrical Bicycle"}]';
$json = "";
	if ($_SESSION['searchtype'] == "name"){
		$mysqli = new mysqli('localhost', 'root', '', 'ces');
		$text = $mysqli->real_escape_string($_GET['term']);

		$query = "SELECT itemID, itemName, itemDescription FROM item WHERE itemName LIKE '%$text%' ORDER BY itemName ASC";
		$result = $mysqli->query($query);
		$json = '[';
		$first = true;
		while($row = $result->fetch_assoc()) {
			if (!$first) { $json .=  ','; } else { $first = false; }
			$json .= '{"value":"'.$row['itemName'].'", "id":"'.$row['itemID'].'", "desc":"'.$row['itemDescription'].'"}';
		}
		$json .= ']';
	
		echo $json;
		//echo '[{"value":"Hanabishi HRC-10SS Rice Cookerrrr"},{"value":"Item Ni SIYA"},{"value":"Junction Box"},{"value":"Xtra Strong Electrical Bicycle"}]';
	}
	else if ($_SESSION['searchtype'] == "desc"){
		$mysqli = new mysqli('localhost', 'root', '', 'ces');
		$text = $mysqli->real_escape_string($_GET['term']);

		$query = "SELECT itemID, itemName, itemDescription FROM item WHERE itemDescription LIKE '%$text%' ORDER BY itemDescription ASC";
		$result = $mysqli->query($query);
		$json = '[';
		$first = true;
		while($row = $result->fetch_assoc()) {
			if (!$first) { $json .=  ','; } else { $first = false; }
			$json .= '{"value":"'.$row['itemName'].'", "id":"'.$row['itemID'].'", "desc":"'.$row['itemDescription'].'"}';
		}
		$json .= ']';
	
		echo $json;
		//echo '[{"value":"Junction Box"},{"value":"Xtra Strong Electrical Bicycle"}]';
	}
}


?>