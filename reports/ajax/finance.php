<?php
include "C:/wamp/www/SMSES/lib/ProjectLibrary.php";
session_start();

$connection = new DatabaseConnection();

//insert CSS
echo "
<style>
#finance-report-table th{
	background-color:white;
	color:black
}
#finance-report-table td{
	border-bottom:1px dotted white;
}
</style>
";

if (isset($_GET['sales'])){
	//Initiate query variables...
	$query = null; $total_sales = 0.00;
	$datestart = null; $dateend = null;
	//Print header
	echo "<div id='content-sub-title'>Sales Report</div>";
	// Get sales report type:
	$report_type = $_POST['timeframe'];
	// Filter query:
	if ($report_type == "Daily"){
		//Get param:
		$day = $_POST['dailydate'];
		$query = "SELECT * FROM receipt WHERE date='$day'";
	}
	else if ($report_type == "Monthly"){
		//Get param:
		$year = $_POST['monthlydate'];$month = $_POST['monthlymonth'];
		//Convert param to date:
		$month = sprintf('%02d',$month);
		$datestart = $year."-".$month."-01"; $dateend = $year."-".$month."-31";
		
		//write query
		$query = "SELECT * FROM receipt WHERE date BETWEEN '$datestart' AND '$dateend'";
	}
	else if ($report_type == "Yearly"){
		//Get param:
		$year = $_POST['yearlyyear'];
		//convert param to date:
		$datestart = $year."-01-01"; $dateend = $year."-12-31";
		//write query
		$query = "SELECT * FROM receipt WHERE date BETWEEN '$datestart' AND '$dateend'";
	}
	
	//Add some charchar...
	echo "Sales $report_type Report";
	if ($report_type == "Daily"){
		echo " on date: ".$_POST['dailydate'];
	}
	else {
		echo " from $datestart to $dateend.";
	} echo "<br />";
	
	
	//Do query:
	$query_result = mysql_query($query);
	if ($query_result){
		if (mysql_num_rows($query_result) == 0){
			echo "Transaction not found in the Database";	
		}
		else {
			//Print Table Header...
			echo "<br/>
			<table id='finance-report-table' cellspacing=0 style='font-size:100%;width:100%;'>
			<th>Date</th><th>OR No.</th><th>Item No.</th><th>Item Name</th><th>Selling Price</th>
			<th>Quantity</th><th>Sales Amount</th>";
		
			while($result = mysql_fetch_array($query_result)){
				echo "<tr>";
				echo "<td>".$result['date']."</td>";
				echo "<td>".$result['receiptNumber']."</td>";
				echo "<td>".$result['ItemID']."</td>";
				//Get item details
				$item = new Item($result['ItemID']);
				echo "<td>".$item->getName()."</td>";
				echo "<td>Php. ".number_format($item->getPrice())."</td>";
				echo "<td>".$result['quantity']."</td>";
				//Get total amount
				$total_amount = $item->getPrice() * $result['quantity'];
				$total_sales = $total_sales + $total_amount;
				echo "<td>Php. ".number_format($total_amount)."</td>";
				echo "</tr>";
			}
			
			//Print total sales...
			echo "</table>";
			echo "<div style='float:right;font-size:125%'>
					Total Sales: Php. ".number_format($total_sales)."
				  </div>";
			
		}
	}
	else {
		echo "ERROR on fetching SQL QUERY";
	}
	
}
else if (isset($_GET['ledger'])){
	echo "<div id='content-sub-title'>Expense Report</div>";
	//Get param:
	$startdate = $_POST['startdate'];
	$enddate = $_POST['enddate'];
	
	$total_expense = 0;
	$query = "SELECT * FROM invoice WHERE date BETWEEN '$startdate' AND '$enddate' ";
	$query_result = mysql_query($query);
	if ($query_result){
		if (mysql_num_rows($query_result) == 0){
			echo "No Transaction recorded...";
		}
		else {
			//Print Table Header...
			echo "<br/>
			<table id='finance-report-table' cellspacing=0 style='font-size:100%;width:100%;'>
			<th>Date</th><th>Invoice No.</th><th>Item Code</th><th>Supplier Code</th>
			<th>Buy Price</th><th>Quantity</th><th>Amount</th>";
		}
		
		while($result = mysql_fetch_array($query_result)){
			echo "<tr>";
			echo "<td>".$result['date']."</td>";
			echo "<td>".$result['invoiceID']."</td>";
			$item = new Item($result['itemID']);
			echo "<td>".$item->getID()."</td>";
			echo "<td>".$result['supplierID']."</td>";
			$buyprice = $item->getPrice() - ($item->getPrice() * 0.1);
			echo "<td>Php. $buyprice</td>";
			echo "<td>".$result['invoicequantity']."</td>";
			$total_price = $buyprice * $result['invoicequantity'];
			echo "<td>Php. $total_price</td>";
			$total_expense = $total_expense + $total_price;
		}
		
		//Print total sales...
			echo "</table>";
			echo "<div style='float:right;font-size:125%'>
					Total Expense: Php. ".number_format($total_expense)."
				  </div>";
	}
	else {
		echo "ERROR IN SQL SYNTAX";
	}

	
}
else if (isset($_GET['income'])){
	echo "<div id='content-sub-title'>Income Statement</div>";
	$startdate = $_POST['startdate'];
	$enddate = $_POST['enddate'];
	
	echo "From:$startdate, To: $enddate <br /><br /><br /> ";
	
	$total_expense = 0; $total_sales = 0;
	
	$query = "SELECT * FROM receipt WHERE date BETWEEN '$startdate' AND '$enddate'";
	$query_result = mysql_query($query);
	if ($query_result){
		if (mysql_num_rows($query_result) == 0){
			echo "Transaction not in database.";
		}
		else {
			while($result = mysql_fetch_array($query_result)){
				$item = new Item($result['ItemID']);
				$total_sales = $total_sales + ($item->getPrice() * $result['quantity']);
			}
		}
	}
	else { echo "ERROR IN SQL SYNTAX"; }
	
	$query = "SELECT * FROM invoice WHERE date BETWEEN '$startdate' AND '$enddate'";
	$query_result = mysql_query($query);
	if ($query_result){
		if (mysql_num_rows($query_result) == 0){
			echo "Transaction not in database.";
		}
		else {
			while($result = mysql_fetch_array($query_result)){
				$item = new Item($result['itemID']);
				$price = $item->getPrice() - ($item->getPrice() * 0.1);
				$total_expense = $total_expense + ( $price* $result['invoicequantity']);
			}
		}
	}
	else { echo "ERROR IN SQL SYNTAX"; }
	
	echo "
		<table id='finance-report-table' style='width:100%;font-size:120%'>
			<tr>
				<td>Total Sales</td><td align='right'> Php. ".number_format($total_sales)." </td>
			</tr>
			<tr>
				<td>Total Expenses</td><td align='right'> Php. ".number_format($total_expense)." </td>
			</tr>
		</table>
	";
	
	
	$total_income = $total_sales - $total_expense;
	echo "<div style='float:right;font-size:125%'>
			Net Income: Php. ".number_format($total_income)."
			</div>";
}

?>




