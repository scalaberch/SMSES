<?php

/* Self defined classes */

class DatabaseConnection {

	private $database_name = "ces";
	private $host = "localhost";
	private $username = "root";
	private $password = "";
	public $connection = null;
	
	public function DatabaseConnection(){
		$connection = mysql_connect($this->host, $this->username, $this->password) or die();
		mysql_select_db($this->database_name, $connection);
		$this->connection = $connection;
		return $connection;
	}
	
	public function CloseConnection(){
		mysql_close($this);
	}
	
}


/* These are the class diagrams that we got from the class diagram... */

class Ledger{
    private $particular;
    private $debt;
    private $credit;
    private $balance;
    
    public function Ledger($data){
		//Precondition: $data is result from SQL Query...
		
        $this->$particular = $data["particular"];
        $this->$debt = $data["debt"];
        $this->$credit = $data["credit"];
        $this->$balance = $data["balance"];
    }
    
    public function getParticular(){
        return $this->$particular;
    }
    
    public function getDebt(){
        return $this->$debt;
    }
    
    public function getCredit(){
        return $this->$credit;
    }
    
    public function getBalance(){
        return $this->$balance;
    }
}


class Supplier{
	private $id;
    private $name;
    private $address;
    
    public function Supplier($data){
		$this->id = $data;
	
		$query = "SELECT * FROM supplier WHERE SupplierID=$data";
		$q = mysql_query($query);
		while($r = mysql_fetch_array($q)){
			$this->name = $r['SupplierName'];
			$this->address = $r['SupplierAddress'];
		}
        
    }
	
	
	
	public static function print_all_suppliers(){
		//This is used for the drop-down box
		$query = "SELECT SupplierID, SupplierName FROM supplier";
		$query_result = mysql_query($query);
		echo "<select id='supplier-list'>";
		while($result = mysql_fetch_array($query_result)){
			echo "<option value='".$result['SupplierID']."'>".$result['SupplierName']."</option>";
		}
		echo "</select>";
		
	}
    public function getName(){
        return $this->name;
    }
    
    public function getAddress(){
        return $this->address;
    }
}


class Receipt{
    private $number;
    private $customer;
    private $date;
    private $totalAmount;
	private $item_list;
	private $amountPaid;
    
    public function Receipt(){
		//Assign new OR#
		$query = mysql_query("SELECT receiptNumber FROM receipt ORDER BY receiptNumber DESC LIMIT 0,1 ");
		while($result = mysql_fetch_array($query)){
			$this->number = $result['receiptNumber'];
		}
        
        $this->date = date("Y-m-d");
        $this->totalAmount = 0.00;
		$this->item_list = array();
		$this->customer = null;
		$this->amountPaid = 0;
    }
    
    public function getNumber(){ return $this->number; }
    public function getCustomer(){ return $this->customer; }
    public function getDate(){ return $this->date; }
    public function getTotalAmount(){ return $this->totalAmount; }
    public function getItemList(){ return $this->item_list; }
    public function getPaid(){ return $this->amountPaid; }

	public function setNumber($value){ $this->number = $value; }
	public function setPaid($value){ $this->amountPaid = $value; }
	public function setCustomer($customer){ $this->customer = $customer; }
    public function setTotalAmount($value){ $this->totalAmount = $value; }
	public function setItemList($array) { $this->item_list = $array; }
	
	public function appendItemList($itemEntry){
		$tempArray = $this->getItemList();
		$tempArray[] = $itemEntry;
		$this->item_list = $tempArray;
	}
    
    public function _print(){
        // To be used in TCPDF
    }
}


class Invoice{
    private $number;
    private $date;
    private $totalAmount;
	private $itemArray; //this is ItemEntry array()
	private $supplier;
    
    public function Invoice(){
		//Check for new invoice number...
		$query = "SELECT invoiceNumber FROM invoice ORDER BY invoiceNumber DESC LIMIT 0, 1";
		$qResult = mysql_query($query);
		while($result = mysql_fetch_array($qResult)){
			$this->number = $result['invoiceNumber'] + 1;
		}
		//Append other information...
        $this->date = date("Y-m-d");
        $this->totalAmount = 0.00;
		$this->itemArray = array();
		$this->supplier = null;
    }
	
	public function setSupplier($supplierID){
		$this->supplier = $supplierID;
	}
	
	public function getSupplier(){ return $this->supplier; }
	public function getItems(){ return $this->itemArray;}
	
	public function addItemToTable($item){
		$tempArray = $this->getItems();
		$tempArray[] = $item;
		$this->itemArray = $tempArray;
	}
	
    public function getNumber(){
        return $this->number;
    }
    
    public function getDate(){
        return $this->date;
    }
    
    public function getTotalAmount(){
        return $this->totalAmount;
    }
	
	public function addTotalAmount($amount){
		$this->totalAmount = $this->getTotalAmount() + $amount;
	}
    
    public function print_invoice($invoice){
        // Description: This function gives a PDF copy of the invoice...
		// Precondition: Needs an invoice... also needs the TCPDF library...
		// Postcondition: gives the reciept...
		
		
    }
}


class Employee{
	private $id;
    private $name;
    private $address;
	private $role;
	
	public function Employee($employee_id){
		$this->id = $employee_id;		
		/* Get all information here... except password...*/
		
		$query = "SELECT * FROM employee WHERE employeeID='$employee_id' ";
		$query_result = mysql_query($query);
		while($result = mysql_fetch_array($query_result)){
			$this->name = $result['employeeName'];
			$this->address = $result['employeeAdress'];
			$this->role = $result['employeePosition'];
		}
	}
    
    public function getID(){ return $this->id; }
    public function getName(){ return $this->name; }
    public function getAddress(){ return $this->address; }
    public function getRole(){ return $this->role; }
}


class InventorySupervisor extends Employee{
    public function manageInventory(){
        /*manage kuno*/
    }
}


class FinanceManager extends Employee{
    public function showBussinessForecast(){
        /*forecast kuno*/
    }
}


class Cashier extends Employee{
    public function receiveCash(){
        /*cash kuno*/
    }
    public function transacPurchaseItem(){
        /*transac kuno*/
    }
}


class Attendant extends Employee{
    public function showToCustomer(){
        /*show kuno*/
    }
}


class Inventory{ //public function statics
    private $totalItem;
    private $connection;
    
    public function Inventory(){
        $this->$connection = mysql_connect("localhost", "root");
        mysql_select_db("item", $db);
    }
    
    public function getTotalItem(){
        return $this->$totalItem;
    }
    
    public function add($entry){
        $result = mysql_query("SELECT * FROM item WHERE ID = '".$entry.getItemNumber."'");
        $fetched = mysql_fetch_array($result);
        mysql_query("UPDATE FROM item WHERE ID = '".$entry.getItemNumber()."' SET quantity = '".$fetched[quantity] + $entry.getQuantity()."'", $this->$connection);
    }
    
    public function delete($entry){
        $result = mysql_query("SELECT * FROM item WHERE ID = '".$entry.getItemNumber."'");
        $fetched = mysql_fetch_array($result);
        mysql_query("UPDATE FROM item WHERE ID = '".$entry.getItemNumber()."' SET quantity = '".$fetched[quantity] - $entry.getQuantity()."'", $this->$connection);
    }
    
    public function showInventory(){
        $result = mysql_query("SELECT * FROM item");
        return $result;
    }
}


class ItemEntry{
    private $quantity;
    private $itemNumber;
    
    public function ItemEntry($item){
		/* (OLD CONSTRUCTOR )
		*
		$query = "SELECT itemID, itemPrice FROM item WHERE itemID='$item' ";
		$query_result = mysql_query($query);
		while($result = mysql_fetch_array($query_result)){
			$this->quantity = $result['itemPrice'];
			$this->itemNumber = $result['itemID'];
		}
		*/
		
		
		$this->itemNumber = $item;
		$this->quantity = 0;
		
    }
    
    public function getQuantity(){
        return $this->quantity;
    }
	
	public function setQuantity($quantity) { $this->quantity = $quantity; }
    
    public function getItemNumber(){
        return $this->itemNumber;
    }
}


class Item{
	private $itemID;
    private $name;
    private $description;
	private $category;
	private $status;
	private $supplier;
	private $price;
  
    public function Item($data){
		$this->itemID = $data;
	    
		if ($data != "NEW"){
			$query = "SELECT * FROM item WHERE itemID='$data' ";
			$query_result = mysql_query($query);
			while($result = mysql_fetch_array($query_result)){
				$this->name = $result['itemName'];
				$this->description = $result['itemDescription'];
				$this->category = $result['categoryID'];
				$this->status = $result['itemStatus'];
				$this->supplier = $result['supplierID'];
				$this->price = $result['itemPrice'];
			}
		}
	}
	
	//public function 
	
	public function getID() { return $this->itemID; }
    public function getName(){return $this->name;} 
    public function getDescription(){ return $this->description; }
    public function getCategory(){ return $this->category; }
    public function getStatus(){ return $this->status; }
    public function getSupplier(){ return $this->supplier; }
    public function getPrice(){ return $this->price; }
	
	//setters
	public function setID($value) { $this->itemID = $value; }
    public function setName($value){ $this->name = $value;} 
    public function setDescription($value){ $this->description = $value; }
    public function setCategory($value){ $this->category = $value; }
    public function setStatus($value){ $this->status = $value; }
    public function setSupplier($value){ $this->supplier = $value; }
    public function setPrice($value){ $this->price = $value; }
	
	public function get_new_item_ID(){
		$query = mysql_query("SELECT itemID FROM item ORDER BY itemID DESC LIMIT 0, 1");
		while($result = mysql_fetch_array($query)){
			$new = $result['itemID'] + 1;
			return $new;
		}
	}
	
	public function is_item_in_database($itemID){
		//Precondition: SYstem has already connected to the database;
		$result = false;
		$query = "SELECT itemID FROM item WHERE itemID='$itemID' ";
		$query_result = mysql_query($query);
		while($result = mysql_fetch_array($query_result)){
			if ($itemID == $result['itemID']){
				$result = true;
				break;
			}
		}
		return $result;
	}
}


class Category{
    private $name;
    public function Category(){
        $this->name = "";
    }
	
	public function print_all_category(){
		//This is used in the drop-down box...
		$query = "SELECT categoryID, categoryName FROM category";
		$query_result = mysql_query($query);
		echo "<select id='category-list'>";
		while($result = mysql_fetch_array($query_result)){
			echo "<option value='".$result['categoryID']."'>".$result['categoryName']."</option>";
		}
		echo "</select>";
	}
    
    public function getName(){
        return $this->name;
    }
}

class Utility {
	public static function redirect($location) {
		echo "<script type='text/javascript'>
				window.open('".$location."', '_self');
			  </script>";
	}
	
	public static function spawn_loading_image($your_wanted_id){
		echo "<div id='".$your_wanted_id."' align='center'>
				<img src='../lib/img/load.gif' />
			  </div>";
	}
}

class NumberToWords {

	private $value;
	
	public function NumberToWords(){
		$value = null;
	}
	
	public function translateNumberToWords($number){
	
	}
	
	public function getDigitLevel($digit){
		switch($digit){
			case 1:
				return "Ones";
			case 2:
				return "Tens";
			case 3:
				return "Hundred";
			case 4:
				return "Thousand";
		}
	}
	
	

}

?>
