<?php
	//include "../lib/ProjectLibrary.php";
	//session_start();
	
	$connection = new DatabaseConnection();
	$category = new Category();
	$supplier = new Supplier(0);

?>
<style>
	.ui-autocomplete {
		max-height: 150px;
		overflow-y: auto;
		/* prevent horizontal scrollbar */
		overflow-x: hidden;
		/* add padding to account for vertical scrollbar */
		padding-right: 20px;
	}
	/* IE 6 doesn't support max-height
	 * we use height instead, but this forces the menu to always be this tall
	 */
	* html .ui-autocomplete {
		height: 150px;
	}
	</style>
<script type='text/javascript'>
var the_head = 0;
$(function() {
	//Hide all error messages...
	$('#error-message-manager-supplier-form').hide(0);
	$('#error-message-add-existing').hide(0);
	//Button default initiator
	$('.buttons').button();
	
	
	$('#error-search-item-dialog').hide(0);
	//Marker here...
	
	$('#add-item-quantity')
		.focus(function () {
			$(this).css('color', 'black');
			$(this).val("");
		})
		.blur(function () {
			if ($(this).val() == ""){
				$(this).css('color', 'grey');
				$(this).val("Quantity");
			}
		});
	
	$('#add-item-field')
		.focus(function () {
			$(this).css('color', 'black');
			$(this).val("");
		})
		.blur(function () {
			if ($(this).val() == ""){
				$(this).css('color', 'grey');
				$(this).val("Enter Item Code here...");
			}
		});
	
	$('#add-item-button').click(function () {
		var search_value = $('#add-item-field').val(),
			search_quantity = $('#add-item-quantity').val();
			
		if (search_value == "" || search_value == "Enter Item Code here..."){
			alert("Please enter an item code or search it on the 'Search Item' button to start.");
		}
		else if (search_quantity <= 0 || search_quantity == "Quantity"){
			alert("Please enter a quantity.");
		}
		else {
			//Check if the item is in the database...
			$.ajax({
				url:"ajax/cash.php?ifThisInDB",
				datatype:"html", type:"POST",
				data: {
					item: search_value
				},
				success: function (data){
					if (data != "true"){
						alert("Item is not in the database. Please check your item ID");
					}
					else {
						//Getting information...
						var location = "ajax/cash.php?json&getItemDetails="+search_value;
						$.getJSON(location, function(json){
							//Update Item Information
							$('#viewer-item-id').html(json.id); 
							$('#viewer-item-name').html(json.name);
							$('#viewer-item-description').html(json.description); 
							$('#viewer-item-category').html(json.price); 
							$('#viewer-item-price').html("Php. "+json.price); 
							
							//Input it to the table...
							var num = $('#queue-table-content tr').length - 1;
							var whoa = $('#queue-table-content tr:last').attr('id');
							if (isNaN(whoa)){
								num = 0;
							}
							else {
								num = parseInt(whoa) + 1;
							}
							var total_amount = parseFloat(json.price) * parseFloat(search_quantity);
							var line = "<tr id='"+num+"'><td>"+json.id+"</td><td>Php. "+json.price+"</td><td>"+search_quantity+"</td><td>"+total_amount+"</td><td><a href='Javascript:delete_rowts("+num+")'><span class='ui-icon ui-icon-closethick'></span></a></td> </tr>";
							$('#queue-table-content tr:last').after(line);
							
							//Update Total Amount
							var totalAmount = parseFloat($('#total-amount').html());
							totalAmount = totalAmount + total_amount;
							$('#total-amount').html(totalAmount);
							
							//Empty fields...
							$('#add-item-field').val("Enter Item Code here..."),
							$('#add-item-quantity').val("Quantity");
							
							//Input it to the AJAX
							$.ajax({
								url: "ajax/cash.php?appendTable",
								datatype:"html", type:"POST",
								data: {
									itemID:search_value,
									itemQuantity:search_quantity,
									recieptTotalQuantity:totalAmount
								}
							});
						});
						//Close the dialog...
					}
				}
			});
		}
	});
	
	$('#search-item-field')
		.autocomplete({
			source:"ajax/cash.php?search",
			minLength:1,
			select: function(event, ui){
				$('#search-item-field').val(ui.item.value);
				$('#search-item-id').val(ui.item.id);
			},
			focus: function(event, ui){
				$('#search-item-field').val(ui.item.value);
			}
		})
		.data("autocomplete")._renderItem = function( ul, item ) {
			return $("<li></li")
						.data("item.autocomplete", item)
						.append("<a><b>" + item.value + "</b><br>" + item.desc + "</a>")
						.appendTo(ul);
		};
	
	$('#search-item-submit')
		.button()
		.click(function() {
			if ($('#search-item-field').val() == ""){
				$('#error-search-item-dialog').show('fade', 500);
				setTimeout( function () {
					$('#error-search-item-dialog').hide('fade', 500);
				}, 3000);
			}
			else {
				var the_id = $('#search-item-id').val();
				$('#add-item-field').val(the_id);
				$('#search-item-dialog').dialog('close');
			}
		});
	
	$('#search-item-button').click(function() {
		$('#search-item-dialog').dialog('open');
	});
	
	$('#search-item-dialog').dialog({
		autoOpen:false, modal:true, show:"fold", hide:"fold"
	});
		
	$("#confirm-transaction-button").button().click(function () {
		//check if there are items in the queue...
		$.ajax({
			url:"ajax/cash.php?checkIfArrayIsNOTEmpty",
			datatype:"html",
			success: function (data){
				if (data == "false"){
					alert("Please enter an item to continue...");
				}
				else {
				$('#payment-dialog-amount').html($('#total-amount').html());
				$('#payment-dialog-recieved').html("");
				$('#payment-dialog-change').html("");
				$('#payment-dialog').dialog('open');
				}
			}
		});
	});
	
	$('#payment-dialog').dialog({
		autoOpen:false, modal:true, width:500
	});
	
	$('#get-payment').dialog({
		autoOpen:false, modal:true,
		buttons: {
			OK: function () {
				var change, 
					recieve = $('#get-payment-field').val(), 
					amount = $('#total-amount').html();
					
				change = recieve - amount;
				$('#payment-dialog-recieved').html(recieve);
				$('#payment-dialog-change').html(change);
			
				$('#get-payment-button').attr('disabled', 'disabled');
				$('#confirm-reciept-button').removeAttr('disabled')
				$('#get-payment-button, #confirm-reciept-button').button('refresh')
				$(this).dialog('close');
			}
		}
	});
	
	$('#get-payment-button').button().click(function () {
	
		$('#confirm-reciept-button').attr('disabled', 'disabled');
		$('#get-payment-button').removeAttr('disabled');
		$('#get-payment-button, #confirm-reciept-button').button('refresh');
		$('#get-payment').dialog('open');

	});
	
	$('#new-transaction-button').button().click(function () {
		initiate();
		$.ajax({
			url:"ajax/cash.php?newTransaction",
			datatype:"html",
			success: function (data){
				if (data == "true"){
					$('#new-transaction-button').hide(0);
					$('#cancel-transaction-button').show(0);
					
					// - Disable some buttons...
					$('#add-item-button').removeAttr("disabled");
					$('#search-item-button').removeAttr("disabled");
					$('#confirm-transaction-button').removeAttr("disabled");
					$('#add-item-button, #search-item-button, #confirm-transaction-button')
						.button("refresh");
						
					//Empty all tables..
					
					var table_head = "<tr><th>Item Code</th><th>Unit Price</th><th>Quantity</th><th>Amount</th><th></th></tr>";
					
					$('#queue-table-content').html(table_head);
					
					//Fix: Empty Item Description...
					$('#viewer-item-id').html("");
					$('#viewer-item-name').html("");
					$('#viewer-item-description').html("");
					$('#viewer-item-category').html("");
					$('#viewer-item-price').html("");
					
					//Disable text boxes...
					$('#add-item-field').removeAttr('disabled');
					$('#add-item-quantity').removeAttr('disabled');
				}
			}
		});
	});
	
	$('#confirm-reciept-button').button().click(function() {
		var pay = $('#payment-dialog-recieved').html(),
			sukli = $('#payment-dialog-change').html();
		//alert(pay);
		$.ajax({
			url:"ajax/cash.php?confirm",
			datatype:"html", type:"POST",
			data: {
				paid: pay,
				change: sukli
			},
			success: function(){
				$('#payment-dialog').dialog('close');
				alert("Transaction Complete!");
				initiate();
				$('#total-amount').html("0.00");
				$('#new-transaction-button').show(0);
				window.open('../print/?receipt');
			}
		});
	});
	
	$('#cancel-transaction-button').button().click(function() {
		$.ajax({
			url:"ajax/cash.php?checkIfTransact",
			datatype:"html",
			success: function (data) {
				if (data == "true"){
					var wantToReset = confirm("There is a transaction going on. Are you sure you want to cancel?");
					if (wantToReset){
						initiate();
						$('#total-amount').html("0.00");
						$('#new-transaction-button').show(0);
					}
				}
				else {
					initiate();
					$('#total-amount').html("0.00");
					$('#new-transaction-button').show(0);
				}
			}
		});
	});
	
	$('#back-button').button().click(function() {
		$.ajax({
			url:"ajax/cash.php?checkIfTransact",
			datatype:"html",
			success: function (data) {
				if (data == "true"){
					var wantToReset = confirm("There is a transaction going on. Are you sure you want to cancel?");
					if (wantToReset){
						window.open('?', '_self');
					}
				}
				else {
					window.open('?', '_self');
				}
			}
		});
	});
	
	/*
	*	Initialize the Form
	* 	This reset everything... :P
	*/
	initiate();
	
});

function initiate(){
	// - Hide the cancel transaction button
	$('#cancel-transaction-button').hide(0);	
	// - Disable some buttons...
	$('#add-item-button').attr("disabled", "disabled");
	$('#search-item-button').attr("disabled", "disabled");
	$('#confirm-transaction-button').attr("disabled", "disabled");
	
	$('#add-item-button, #search-item-button, #confirm-transaction-button')
		.button("refresh");
	//Disable text boxes...
	$('#add-item-field').attr('disabled', 'disabled');
	$('#add-item-quantity').attr('disabled', 'disabled');
	
	//Fix: Empty Item Description...
	$('#viewer-item-id').html("");
	$('#viewer-item-name').html("");
	$('#viewer-item-description').html("");
	$('#viewer-item-category').html("");
	$('#viewer-item-price').html("");
	
	$('#get-payment-button').removeAttr('disabled');
	$('#confirm-reciept-button').attr('disabled', 'disabled');
	$('#get-payment-button, #confirm-reciept-button')
		.button('refresh');
	
	//Empty all tables..
	var table_head = "<tr><th>Item Code</th><th>Unit Price</th><th>Quantity</th><th>Amount</th></tr>";
	$('#queue-table-content').html(table_head);
	
	// - FixED: unset SESSION holder for invoices...
	$.ajax({
		url:"ajax/cash.php?deleteTransaction",
		datatype:"html"
	});
}

function delete_rowts(value){
	//remove the tables
/*
	$('#'+value+'').remove();
	//rename all the id's
	var size = $('#queue-table-content tr').length;
	for (var i=0; i<size; i++){
		alert(i);
		$('#queue-table-content tr:last').after(line);
	}
	//minus the value...
	var total_amount = $('#total-amount').html();
	alert(total_amount);
	$.ajax({
		//get details for amount...
		url: "ajax/cash.php?getamounttotal",
		datatype:"html", type:"POST",
		data: {
			index: value
		},
		success: function (data) {
			var new_total = total_amount - data;
			$('#total-amount').html(new_total);
			//call ajax again for the edition of the files...
			$.ajax({
				url: "ajax/cash.php?removeItem",
				datatype:"html", type:"POST",
				data: {
					index:value
				}
			});
		}
	});
*/

	//alert($('#queue-table-content tr').length - 1);
	//remove the tables...
	$('#'+value+'').remove();
	$.ajax({
		url:"ajax/cash.php?removeItem",
		datatype:"html", type:"POST",
		data: {
			index:value
		},
		success: function (data) {
			$('#total-amount').html(data);
		}
	});
	//alert($('#queue-table-content tr').length - 1);
/*
	//recalculate the table ids...
	var i; var size = $('#queue-table-content tr').length;
	for (i=0; i<size; i++){
		//.alert(i);
		if (i == value){
			$('#'+value+'').attr('id', 'X');
		}
		else if (i {
			
		}
	} */
	
}
</script>

<div id='content-container' align='center'><form>
	<div id='content' align='left' class='rounded-corners'>
		<div id='content-title'>
			Cash Register
		</div>
		<div id='content-menu-buttons'>
	<!--		<a href='?'>Back to Inventory Menu&nbsp </a> -->
		</div>
		
		<div id='cash-drawer-container'>
			<div id='purchase-queue-container' >
				<div id='content-sub-title'>
				Items Queue
				</div>
				<div id='add-queue-container' style='margin-left:0px;'>
					<input type='text' id='add-item-field' value='Enter Item Code here...' style='width:66%;color:grey' />
					<input type='text' id='add-item-quantity' value='Quantity' style='width:12%;color:grey' />
					<input type='button' id='add-item-button' class='button' style='width:20%' value='Add Item'>	
					<input type='button' id='search-item-button' class='button' style='width:100%' value='Search for an Item'>	
				</div>
				<div id='queue-table'>
				<table id='queue-table-content' style='width:100%' cellspacing=0>
					<th>Item Code</th><th>Unit Price</th><th>Quantity</th><th>Amount</th><th></th>
					<!-- recurse fetching data from db here 
					<tr><td>1234</td><td>3400</td><td>4</td><td>20000</td></tr>
					-->
					<tr></tr>
					
				</table>
				</div>
			</div>
		<div id='purchase-navigation-container'>
			<div id='queue-item-description' style='height:35%;'>
				<div id='content-sub-title'>Item Description</div>
				<b>Item ID:</b> <span id='viewer-item-id'></span><br />
				<b>Item Name: </b><span id='viewer-item-name'></span><br />
				<b>Item Description: </b><span id='viewer-item-description'></span><br />
				<b>Item Category: </b><span id='viewer-item-category'></span><br />
				<b>Item Price: </b><span id='viewer-item-price'></span><br />
			</div>
			<div id='purchase-navigation'>
				<div id='content-sub-title'>Total Amount
				<span style='float:right'>Php.
					<span id='total-amount' >
						0.00
					</span>
				</span>
				</div>
				<ul id='purchase-buttons'>
					<li>
						<input type='button' class='button' id='confirm-transaction-button' style='width:100%' value='Confirm Transaction' />
					</li>
					<li id='new-transaction-holder'>
						<input type='button' id='new-transaction-button' class='button' style='width:100%' value='New Transaction' />	
					</li>
					<li id='cancel-transaction-holder'>
						<input type='button' id='cancel-transaction-button' class='button' style='width:100%' value='Cancel Transaction' />	
					</li>
					<li>
						<a href='#' id='back-button' class='button' style='width:100%'>
							Back to Financial Menu
						</a>
					</li>
					
				</ul>
			</div>
		</div>
		</div>
	</div>
</div>

<!-- jQuery Dialogs -->

<div id='search-item-dialog' title='Search for an item'>
	Please enter the item name here:
	<input type='text' id='search-item-field' style='width:99%'/>
	<input type='text' id='search-item-id' hidden='hidden' style='width:99%'/>
	<div id='error-search-item-dialog' class="ui-state-error ui-corner-all" align='center' style="padding:0.7 em;color:red;width:91%"> 
		Please enter an item.
	</div>
	<input type='button' id='search-item-submit' style='width:99%' value='Add Item ID to Search Field' />
</div>

<!--
<div id='customer-dialog' title='Enter Customer Name...'>
	<input type='text' value='Enter customer name...' />
</div>
-->
<div id='payment-dialog'>
	<p>
		<div id='content-sub-title' style='border-bottom:1px dotted white;font-size:125%;'>
			Transaction Details
		</div>
		<table style='font-size:100%;margin-top:5px;' cellpadding=5 cellspacing=1 >
			<tr><td style='color:black;background-color:white'>Total Amount</td><td>Php.<span id='payment-dialog-amount'></span> </td></tr>
			<tr><td style='color:black;background-color:white'>Amount Recieved</td><td>Php. <span id='payment-dialog-recieved'></span> </td></tr>
			<tr><td style='color:black;background-color:white'>Change</td><td>Php. <span id='payment-dialog-change'></span></td></tr>
		</table>
	</p>
	<p align='right'>
		<input type='button' class='button' id='get-payment-button' style='width:100%' value='Get Payment' />
		<input type='button' class='button' disabled='disabled' id='confirm-reciept-button' style='width:100%' value='Confirm Reciept' />
	</p>
</div>

<div id='get-payment' align='center'> 
	Amount Recieved: Php <input type='text' id='get-payment-field' value='0'/>
</div>

<!-- 
<div id='error-message-add-existing' class="ui-state-error ui-corner-all" align='center' style="padding:0.7 em;color:red;width:95%"> 
	Item Code is not yet filled up. Please search for an item.
</div>
-->