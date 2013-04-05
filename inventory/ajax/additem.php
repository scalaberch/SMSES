<?php
	include "C:/wamp/www/SMSES/lib/ProjectLibrary.php";
	session_start();
	
	//Start DB Connection
	$connection = new DatabaseConnection();
	
//Helper function...
function has_transaction(){
	if (isset($_SESSION['invoice'])){
		return true;
	}
	else { return false; }
}

function echo_has_transaction(){
	if (has_transaction()){
		echo "true";
	} else { echo "false"; }
}

function delete_transaction(){
	unset($_SESSION['invoice']);
}


//Method AJAX Calls
if (isset($_GET['checktransaction'])){
	echo_has_transaction();
}
else if (isset($_GET['session-view'])){
	if (has_transaction()){
		print_r($_SESSION['invoice']);
	}
}
else if (isset($_GET['isInDB'])){
	$nom = $_POST['search'];
	$sql = "SELECT itemID FROM item WHERE itemName='$nom' ";
	$query = mysql_query($sql);
	if ($query){
		if (mysql_num_rows($query) != 0){
			echo "true";
		}
	}
}
else if (isset($_GET['newtransaction'])){
	//Reset transaction
	delete_transaction();
	//Create new Instance of Invoice
	$newInvoice = new Invoice();
	//Store instance to SESSION...
	$_SESSION['invoice'] = $newInvoice;
	//Sentiniel
	//echo_has_transaction();
	echo $newInvoice->getNumber();

}
else if (isset($_GET['deleteTransaction'])){
	delete_transaction();
}
else if (isset($_GET['setSupplier'])){

	//Get Supplier ID for supplierName
	//$_POST['supplierName'] = "ChinaMade";
	$query = "SELECT SupplierID, SupplierAddress FROM Supplier WHERE SupplierName='".$_POST['supplierName']."'";
	$query_result = mysql_query($query);
	while($result = mysql_fetch_array($query_result)){
		$_SESSION['invoice']->setSupplier($result['SupplierID']);
		echo $result['SupplierAddress'];
		//echo "true";
	}
}
else if (isset($_GET['appendItem'])){
	$itemEntry = null;
	if (isset($_GET['new'])){
		$ID = "NEW";
		//Set new Item and item info
		$item = new Item($ID);
		$item->setName($_POST['ItemName']);
		$item->setDescription($_POST['ItemDescription']);
		$item->setPrice($_POST['ItemPrice']);
		$item->setCategory($_POST['ItemCategory']);
		$item->setStatus("GOOD");
		
		//encapsulate it in an ItemEntry;
		$itemEntry = new ItemEntry($item);
		$itemEntry->setQuantity($_POST['ItemQuantity']);
		
		
		//append to array...
		//$_SESSION['invoice']->addItemToTable($item);
		$_SESSION['invoice']->addItemToTable($itemEntry);
		
		
		//change value of total amount...
		$total_amount = $_POST['ItemQuantity'] + $_POST['ItemPrice']; //TO BE FIX...
		$_SESSION['invoice']->addTotalAmount($total_amount);
	}
	else if (isset($_GET['existing'])){
		//Check if current supplier is the supplier of this item...
		//Tezt
		//$_POST['id'] = 2;
		$item = new Item($_POST['id']);
	
	// COMMENTED OUT... para char char... 
	/*
		if ($item->getSupplier() != $_SESSION['invoice']->getSupplier()){
			//Treat this as a NEW ITEM...
			$newItem = new Item("NEW");
			$newItem->setName($item->getName());
			$newItem->setDescription($item->getDescription());
			$newItem->setCategory($item->getCategory());
			$newItem->setStatus("GOOD");
			
			//Set new price...
			$newItem->setPrice($_POST['ItemPrice']);
			
			//Encapsulate it to new ItemEntry
			$itemEntry = new ItemEntry($newItem);
			$itemEntry->setQuantity($_POST['ItemQuantity']);
			
			//append to array...
			$_SESSION['invoice']->addItemToTable($itemEntry);
		}
		else {
	*/
			//Create New Instance of Item: Oops... mao na d.i tong nasa taas...
			
			//set new price... 
			$item->setPrice($_POST['price']);
			
			//Encapsulate it to new ItemEntry
			$itemEntry = new ItemEntry($item);
			$itemEntry->setQuantity($_POST['quantity']);
			
			//append to array...
			$_SESSION['invoice']->addItemToTable($itemEntry);
	
	//} DONT ERASE THIS LINE...
		
	}
	
	//Append to array...
}
else if (isset($_GET['autocomplete'])){
	$json = "";
	if (isset($_GET['supplierName'])){
		$mysqli = new mysqli('localhost', 'root', '', 'ces');
		$text = $mysqli->real_escape_string($_GET['term']);

		$query = "SELECT SupplierName FROM supplier WHERE SupplierName LIKE '%$text%' ORDER BY SupplierName ASC";
		$result = $mysqli->query($query);
		$json = '[';
		$first = true;
		while($row = $result->fetch_assoc()) {
			if (!$first) { $json .=  ','; } else { $first = false; }
			$json .= '{"value":"'.$row['SupplierName'].'"}';
		}
		$json .= ']';
	
		echo $json;
	}
	else if (isset($_GET['itemName'])){
		
		$mysqli = new mysqli('localhost', 'root', '', 'ces');
		$text = $mysqli->real_escape_string($_GET['term']);
		
		$supplier = $_SESSION['invoice']->getSupplier();

		$query = "SELECT itemName FROM item WHERE itemName LIKE '%$text%' AND supplierID=$supplier ORDER BY itemName ASC";
		$result = $mysqli->query($query);
		$json = '[';
		$first = true;
		while($row = $result->fetch_assoc()) {
			if (!$first) { $json .=  ','; } else { $first = false; }
			$json .= '{"value":"'.$row['itemName'].'"}';
		}
		$json .= ']';
	
		echo $json;
		
		//echo '[{"value":"Hanabishi HRC-10SS Rice Cookerrrr"},{"value":"Item Ni SIYA"},{"value":"Junction Box"},{"value":"Xtra Strong Electrical Bicycle"}]';
	}
}
else if (isset($_GET['json'])){
	if (isset($_GET['fromItemName'])){
		$item = $_GET['fromItemName'];
		//echo $item;
		$query = "SELECT itemID, itemName, itemDescription, itemPrice, itemQuantity, categoryID FROM item WHERE itemName='$item'";
		$query_result = mysql_query($query);
		while($result = mysql_fetch_array($query_result)){
			$cat = $result['categoryID'];
			$query2 = "SELECT categoryName FROM category WHERE categoryID=$cat";
			$query_result2 = mysql_query($query2);
			while($result2 = mysql_fetch_array($query_result2)){
				$price = $result['itemPrice'] - ($result['itemPrice'] * 0.1);
				$json = '{"id":"'.$result['itemID'].'",
					  "name":"'.$result['itemName'].'",
					  "description":"'.$result['itemDescription'].'",
					  "price":"Php. '.$price.'",
					  "quantity":"'.$result['itemQuantity'].'",
					  "category":"'.$result2['categoryName'].'"}';
			}	
		}
		
		echo $json;
	}
}
else if (isset($_GET['submit'])){
	if (isset($_GET['checkIfThereIsTransaction'])){
		$contents = $_SESSION['invoice']->getItems();
		if (empty($contents)){
			echo "false";
		}
		else {
			echo "true";
		}
	}
	else {
		$total_amount = $_POST['total'];
		//get the array...
		$contents = $_SESSION['invoice']->getItems();
		//echo sizeof($contents);
		$id = 0;
		for ($i = 0; $i<sizeof($contents); $i++){
			$currentItem =  $contents[$i]->getItemNumber();
			$query = null;
			if ($currentItem->getID() == "NEW"){
				$newID = $currentItem->get_new_item_ID();
				//echo $newID;
				$price = $currentItem->getPrice() + ($currentItem->getPrice() * 0.1);
				$id = $newID;
				$query = "INSERT INTO item 
							(`itemID`, `categoryID`, `itemDescription`, 
							`itemName`, `supplierID`, `itemQuantity`, 
							`itemDateLastAdded`, `itemStatus`, `itemPrice`) 
						  VALUES 
							('".$id."', ".$currentItem->getCategory().", '".$currentItem->getDescription()."', 
							'".$currentItem->getName()."', ".$_SESSION['invoice']->getSupplier().", ".$contents[$i]->getQuantity().", 
							'".date("Y-m-d")."', 'GOOD', '".$price."')";
							
			}
			else {
				//Get old quantity
				$subquery = "SELECT itemQuantity FROM item WHERE itemID=".$currentItem->getID();
				$subquery_result = mysql_query($subquery); $oldquantity = 0;
				while($sub_result = mysql_fetch_array($subquery_result)){
					$oldquantity = $sub_result['itemQuantity'];
				}
				
				//new quantity
				$newquantity = $oldquantity + $contents[$i]->getQuantity();
				
				$id = $currentItem->getID();
				//change it
				// changes are: quantity and price...
				$query = "UPDATE item 
				SET itemQuantity = ".$newquantity.",
					itemPrice = ".$currentItem->getPrice().",
					itemDateLastAdded = '".date("m/d/Y")."'
				WHERE itemID = ".$id;
			}
			//echo $query . "<br />";
			mysql_query($query);
			
			//then, save transaction to table "invoice"
			$query = "INSERT INTO invoice
						(invoiceID, invoiceNumber, supplierID,
						 employeeID, itemID, date, invoiceQuantity)
					  VALUES
						(NULL, ".$_SESSION['invoice']->getNumber().", ".$_SESSION['invoice']->getSupplier().",
						".$_SESSION['user']->getID().", ".$id.", '".date("Y-m-d")."', ".$total_amount.")
						
						";
			mysql_query($query);
		}
		
		// save a copy of this transaction to table "ledger"
		$query = "INSERT INTO ledger (ledgerID, receiptNumber, invoiceNumber)
					VALUES(NULL, 0, ".$_SESSION['invoice']->getNumber().")";				
		mysql_query($query);
		
		// also, send this to the print invoice...
		$_SESSION['printqueue'] = $_SESSION['invoice'];
		
		//sentiniel
		echo "true";
	}
}

?>