<?php

	$mysqli = new mysqli('localhost', 'root', '', 'ces');
	$text = $mysqli->real_escape_string($_GET['term']);

	//$query = "SELECT name FROM bands WHERE name LIKE '%$text%' ORDER BY name ASC"; '%$text%'
	$query = "SELECT itemName FROM item WHERE itemName LIKE '%$text%' ORDER BY itemName ASC";
	$result = $mysqli->query($query);
	$json = '[';
	$first = true;
	while($row = $result->fetch_assoc()) {
		if (!$first) { $json .=  ','; } else { $first = false; }
		$json .= '{"value":"'.$row['itemName'].'"}';
	}
	$json .= ']';
	
	echo $json;
	
?>