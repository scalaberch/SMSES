<?php
include "C:/wamp/www/SMSES/lib/ProjectLibrary.php";
session_start();
$connection = new DatabaseConnection();

if(isset($_GET['search'])){
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
}
else if (isset($_GET['ifThisInDB'])){ //Checking if the item is in DB...
	$item = new Item($_POST['item']);
	if ($item->is_item_in_database($item->getID())){
		echo "true";
	}
}
else if (isset($_GET['json'])){ //json data files
	if (isset($_GET['getItemDetails'])){
		$itemID = $_GET['getItemDetails'];
		$item = new Item($itemID);
		
		$json = '{"id":"'.$item->getID().'",
				  "name":"'.$item->getName().'",
			      "description":"'.$item->getDescription().'",
			      "price":"'.$item->getPrice().'"}';
				  
		echo $json;
	}
}
else if (isset($_GET['appendTable'])){
	//initiate new item
	$item = new Item($_POST['itemID']);
	//initiate new itemEntry
	$itemEntry = new ItemEntry($item);
	$itemEntry->setQuantity($_POST['itemQuantity']);
	//append to item list of receipt
	$_SESSION['receipt']->appendItemList($itemEntry);
	
	//update total amount:
	$_SESSION['receipt']->setTotalAmount($_POST['recieptTotalQuantity']);
}
else if (isset($_GET['newTransaction'])){
	$_SESSION['receipt'] = new Receipt();
	if (isset($_SESSION['receipt'])){
		echo "true";
	}
}
else if (isset($_GET['deleteTransaction'])){
	unset($_SESSION['receipt']);
	if (!isset($_SESSION['receipt'])){
		echo "true";
	}
}
else if (isset($_GET['checkIfArrayIsNOTEmpty'])){
	$array = $_SESSION['receipt']->getItemList();
	if (empty($array)){
		echo "false";
	}
	else {
		echo "true";
	}
}
else if (isset($_GET['getamounttotal'])){
	$i = $_POST['index'];
	$itemEntryArray = $_SESSION['receipt']->getItemList();
	$quantity = $itemEntryArray[$i]->getQuantity();
	$price = $itemEntryArray[$i]->getItemNumber()->getPrice();
	echo $quantity*$price;
}
else if (isset($_GET['removeItem'])){
	//$_POST['index'] = 0;
	//get the index from the ajax:
	$index = $_POST['index'];
	//get the array of the receipt..
	$itemList = $_SESSION['receipt']->getItemList();
	//get the total price of the entry...
	$entryPrice = $itemList[$index]->getQuantity() * $itemList[$index]->getItemNumber()->getPrice();
	//echo $entryPrice;
	//decrement total numbers...
	$totalAmount = $_SESSION['receipt']->getTotalAmount() - $entryPrice;
	$_SESSION['receipt']->setTotalAmount($totalAmount);
	//then remove the spec item...
	unset($itemList[$index]);
	//$itemList = array_values($itemList);
	$_SESSION['receipt']->setItemList($itemList);
	echo $_SESSION['receipt']->getTotalAmount();
}
else if (isset($_GET['confirm'])){
	

	$paid = $_POST['paid'];
	$change = $_POST['change'];
	
	$_SESSION['receipt']->setPaid($paid);
	//Initiate Values
	
	//Find New Receipt ID
	$query = mysql_query("SELECT receiptNumber FROM receipt ORDER BY receiptNumber DESC LIMIT 0, 1");
	while($value = mysql_fetch_array($query)){
		$_SESSION['receipt']->setNumber($value['receiptNumber']);
	}
	
	//get itemEntry array
	$itemEntryArray = $_SESSION['receipt']->getItemList();
	for ($i = 0; $i<sizeof($itemEntryArray)+1; $i++){
		if (empty($itemEntryArray[$i])){
			//echo "Foo";
		}
		else {
			$item = $itemEntryArray[$i]->getItemNumber();
		
			$query = "INSERT INTO receipt
					(receiptID, receiptNumber, employeeID, itemID, date, quantity)
				  VALUES
					(NULL, ".$_SESSION['receipt']->getNumber().",
					".$_SESSION['user']->getID().",".$item->getID().", '".$_SESSION['receipt']->getDate()."',
					".$itemEntryArray[$i]->getQuantity()."
					)
				";
			echo $query."<br />";
			mysql_query($query);
		}
	}

	$query = "INSERT INTO ledger(ledgerID, receiptNumber, invoiceNumber)
				VALUES (NULL, ".$_SESSION['receipt']->getNumber().", 0)";
	mysql_query($query);
	
	$_SESSION['printqueue'] = $_SESSION['receipt'];
		
	//then, enter receipt into ledger...
}
else if (isset($_GET['checkIfTransact'])){
	if (isset($_SESSION['receipt'])){
		echo "true";
	}
}

else if (isset($_GET['viewer'])){
	print_r($_SESSION['receipt']);
}


?>