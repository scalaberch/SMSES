<?php
	//include "../lib/ProjectLibrary.php";
	//session_start();
	
	$connection = new DatabaseConnection();
	$category = new Category();
	$supplier = new Supplier(0);

?>
<script type='text/javascript'>
$(function() {
	//Hide all error messages...
	$('#error-message-manager-supplier-form').hide(0);
	$('#error-message-add-existing').hide(0);
	//Button default initiator
	$('.buttons').button();
	//Autocomplete: Set Supplier Form
	$('#supplier-field').autocomplete({
		source: "ajax/additem.php?autocomplete&supplierName",
		minLength:2
	});
	
	/* Confirm Transactioin :P */
	
	$("#confirm-transaction-button").button().click(function () {
		//var confirm = confirm("Are you sure with this transaction? Please click OK to confirm.");
		
		var total_amount = $('#total-amount').html();
		//Check first if there are entries in the invoice...
		$.ajax({
			url: "ajax/additem.php?submit&checkIfThereIsTransaction",
			datatype:"html",
			success: function (data){
				if (data == "false"){
					alert("Please enter data into the invoice..");
				}
				else {
					var isConfirmed = confirm("Are you sure with this transaction? Please click OK to confirm.");
					if (isConfirmed){
						$.ajax({
							url:"ajax/additem.php?submit",
							datatype:"html",
							type:"POST",
							data:{
								total: total_amount
							},
							success: function () {
								alert("Transaction successfully completed. Redirecting you to another page to show the reciept");
								initiate();
								window.open("../print");
							}
						});
					}
				}
			}
		});
	});
	
	/*
	 * Adding New Item Elements
	 */
	
	//Add New Item Button
	$('#add-item-new-button').click(function () {
		$('#add-item-form').dialog('open');
	});
	//Add New Item Form
	$('#add-item-form').dialog({
			autoOpen:false, modal: true, width:500,
			show:"fold", hide:"fold"
		});
	//Add New Item Confirm Button
	$('#add-new-add-item-button').click( function() {
			var itemName =  $("#add-new-item-name-field").val(),
				itemQuantity = $("#add-new-quantity-field").val(),
				itemDescription = $("#add-new-description-field").val(),
				itemPrice = $("#add-new-price-field").val();
				itemCategory = $('#category-list').val();
		
			var if_not_okay = (itemName == "" || itemQuantity == "" || itemDescription == "" || itemPrice == "");
		
			//allFields.val("chucky");
			if (if_not_okay){
				alert("Please enter their respective values...");
			}
			else {
				//Fix: Add this to the queue...
				$.ajax({
					url: "ajax/additem.php?appendItem&new",
					datatype:"html", type:"POST",
					data: {
						ItemName:itemName,
						ItemQuantity:itemQuantity,
						ItemDescription:itemDescription,
						ItemPrice:itemPrice,
						ItemCategory: itemCategory
					}
				});
				
				//For Now: append to table
				var total_price = parseFloat(itemQuantity)*parseFloat(itemPrice);
				var line = "<tr><td>NEW ITEM</td><td> Php. "+parseFloat(itemPrice)+"</td><td>"+itemQuantity+"</td><td>Php. "+ parseFloat(total_price) +"</td></tr>";
				$('#queue-table-content tr:last').after(line);
				
				//Get value of total amount and edit it...
				var invoice_total = $('#total-amount').html();
				var newinvoice_total = parseFloat(invoice_total) + parseFloat(total_price);
				$('#total-amount').html(newinvoice_total);
				
				//Close Form
				$('#add-item-form').dialog("close");
			}
		});
	//Add New Item Reset Button
	$('#add-new-reset-field-button').click( function() {
			var allFields = $( [] ).add( $( "#add-new-item-name-field" ) ).add($("#add-new-quantity-field")).add($("#add-new-description-field")).add($("#add-new-price-field"));				
			allFields.val("");
		});
	//Add New Item Exit Button
	$('#add-new-close-dialog-button').click( function() {
			$('#add-item-form').dialog('close');
		});
	
	/*
	 * Adding Existing Item Elements
	 */
	 
	 //Add Existing Item BUtton
	 $('#add-item-existing-button').click (function () {
		$('#add-item-existing-form').dialog("open");
	 });
	 //Add Exisiting Item Form
	 $('#add-item-existing-form').dialog({
		autoOpen:false, modal:true, width:500, show:"fold", hide:"fold"
	 });
	 //Add Existing Item: Fill up Search Form
	 $('#search-for-existing-item').click (function () {
		var search_result = $('#search-for-existing-field').val(),
			location = "ajax/additem.php?json&fromItemName="+search_result;

		$.getJSON(location, function(json){
			$('#search-existing-item-id').html(json.id); 
			$('#search-existing-item-name').html(json.name);
			$('#search-existing-item-description').html(json.description); 
			$('#search-existing-item-category').html(json.category); 
			$('#search-existing-item-price-view').html(json.price); 
			$('#search-existing-currrent-quantity').html(json.quantity); 
		});
	 });
	 //Add Existing Item: Search Autocomplete...
	 $('#search-for-existing-field').autocomplete({
		source: "ajax/additem.php?autocomplete&itemName",
		minLength:2
	 });
	 //Add Exisiting Item: Close Dialog
	 $('#add-existing-close-dialog-button').click(function () {
		$('#add-item-existing-form').dialog('close');
	 });
	 //Add Exisiting Item: Submit
	 $('#add-existing-add-item-button').click(function () {
		var itemcode = $('#search-existing-item-id').html(),
			itemquantity = $('#search-existing-item-quantity').val(),
			itemprice = $('#search-existing-item-price').val();
			
		//alert(itemprice);
		//alert($('#search-existing-item-price').val());
		
		if (itemcode == ""){
			$('#error-message-add-existing').show('fade', 500);
			setTimeout(function () {
				$('#error-message-add-existing').hide('fade', 500);
			}, 3000);
		}
		else if (itemquantity == ""){
			$('#error-message-add-existing').html("Please enter the quantity.");
			$('#error-message-add-existing').show('fade', 500);
			setTimeout(function () {
				$('#error-message-add-existing').hide('fade', 500);
				$('#error-message-add-existing').html("Item Code is not yet filled up. Please search for an item.");				
			}, 3000);
		}
		else if (itemprice == ""){
			$('#error-message-add-existing').html("Please enter the purchasing price.");
			$('#error-message-add-existing').show('fade', 500);
			setTimeout(function () {
				$('#error-message-add-existing').hide('fade', 500);
				$('#error-message-add-existing').html("Item Code is not yet filled up. Please search for an item.");				
			}, 3000);
		}
		else {
			
			//Append the data to the table.. (for now)...
			var total_price = parseFloat(itemquantity)*parseFloat(itemprice);
			var line = "<tr><td>"+itemcode+"</td><td> Php. "+parseFloat(itemprice)+"</td><td>"+itemquantity+"</td><td>Php. "+ parseFloat(total_price) +"</td></tr>";
			$('#queue-table-content tr:last').after(line);
			
			//Get value of total amount and edit it...
			var invoice_total = $('#total-amount').html();
			var newinvoice_total = parseFloat(invoice_total) + parseFloat(total_price);
			$('#total-amount').html(newinvoice_total);
			
			$.ajax({
				url:"ajax/additem.php?appendItem&existing",
				datatype:"html",
				type:"POST",
				data: {
					id:itemcode,
					quantity:itemquantity,
					price:itemprice
				}
			});
			
			//Close dialog
			$('#add-item-existing-form').dialog('close');
		}
		
	 });
	 
	//Set Supplier Form
	$('#setSupplierForm').dialog({
			autoOpen:false, modal:true, width:350,
			buttons: {
				"Set Supplier": function () {
					
					var supplier = $("#supplier-field").val();
					if (supplier == ""){
						$('#error-message-manager-supplier-form').show('fade', 500);
						setTimeout(function () {
							$('#error-message-manager-supplier-form').hide('fade', 500);
						}, 3000);
					}
					else {
						//call ajax...
						$.ajax({
							url:"ajax/additem.php?setSupplier",
							datatype:"html",
							type: "POST",
							data: {
								supplierName: supplier
							},
							success: function (data) {
								if (data != ""){
									//append to information...
									$('#viewer-supplier-name').html(supplier);
									$('#viewer-supplier-address').html(data);
									$('#setSupplierForm').dialog('close');
								}
								else {
									$('#error-message-manager-supplier-form').html("Supplier is not registered in the database.");
									$('#error-message-manager-supplier-form').show('fade', 500);
									setTimeout( function () {
										$('#error-message-manager-supplier-form').hide('fade', 500);
										$('#error-message-manager-supplier-form').html("Please enter a supplier.");
									}, 3000);
								}
							}
						});
					}
				},
				"Cancel": function () {
					//alert("You may enter the supplier by the next time, but you cannot confirm this transaction without entering the supplier.");
					$(this).dialog('close');
				}
			}
	});
	//Cancel Transaction Button
	$('#cancel-transaction-button').button().click(function () {
			var isCanceled = confirm("There is a transaction going on. Are you sure you want to cancel? Press OK to Confirm.");
			if (isCanceled){
				$.ajax({
					url:"ajax/additem.php?deleteTransaction",
					datatype:"html",
					success: function () {
						//Reset All Tables... again...
						var table_head = "<tr><th>Item Code</th><th>Unit Price</th><th>Quantity</th><th>Amount</th></tr>";
						$('#queue-table-content').html(table_head);
						
						//Reset Information
						$('#viewer-item-id').html("");
						$('#viewer-supplier-name').html("");
						$('#viewer-supplier-address').html("");
						$('#total-amount').html("0.00");
						
						//Disable All Buttons...
						$('#cancel-transaction-button').hide(0); 
						$('#new-transaction-button').show(0); 

						$('#add-item-new-button').attr("disabled", "disabled");
						$('#add-item-existing-button').attr("disabled", "disabled");
						$('#confirm-transaction-button').attr("disabled", "disabled");
	
						$('#add-item-new-button, #add-item-existing-button, #confirm-transaction-button').button("refresh");
					}
				});
			}
		});
	//New Transaction Button
	$('#new-transaction-button').button().click( function () {
			//Call AJAX to set new Invoice...
			$.ajax({
				url:"ajax/additem.php?newtransaction",
				datatype:"html",
				success: function (data) {
					if (data != ""){
						//Show Supplier Field
						$('#setSupplierForm').dialog('open');
						
						// Show the Invoice ID:
						$('#viewer-item-id').html(data);
						
						//Change Button:
						$('#add-item-new-button').removeAttr("disabled");
						$('#add-item-existing-button').removeAttr("disabled");
						$('#confirm-transaction-button').removeAttr("disabled");
	
						$('#add-item-new-button, #add-item-existing-button, #confirm-transaction-button').button("refresh");
						
						$('#new-transaction-button').hide(0);
						$('#cancel-transaction-button').show(0);
					}
				}
			});
		
		});
	//Back to Inventory Menu Button
	$('#back-button').button() .click(function() {
			//check if there is an existing transaction
			//	if there is any... prompt it otherwise,
			$.ajax({
				url:"ajax/additem.php?checktransaction",
				datatype:"html",
				success: function (data){
					if (data == "true"){
						var want_exit = confirm("There is still a transaction going on. Do you want to exit? Press OK to Confirm.");
						if (want_exit){
							//exit strategy...
							$('#content-container').hide('drop', 700);
							setTimeout( function () {
								window.open('?inventory', '_self');
							}, 800);
						}
					}
					else {
						//exit strategy...
						$('#content-container').hide('drop', 700);
						setTimeout( function () {
							window.open('?inventory', '_self');
						}, 800);
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
	$('#add-item-new-button').attr("disabled", "disabled");
	$('#add-item-existing-button').attr("disabled", "disabled");
	$('#confirm-transaction-button').attr("disabled", "disabled");
	
	$('#add-item-new-button, #add-item-existing-button, #confirm-transaction-button')
		.button("refresh");
	//Empty all tables..
	var table_head = "<tr><th>Item Code</th><th>Unit Price</th><th>Quantity</th><th>Amount</th></tr>";
	$('#queue-table-content').html(table_head);
	
	// - Fix: unset SESSION holder for invoices...
	$.ajax({
		url:"ajax/additem.php?deleteTransaction",
		datatype:"html"
	});
}
</script>

<div id='content-container' align='center'><form>
	<div id='content' align='left' class='rounded-corners'>
		<div id='content-title'>
			Inventory Add Items 
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
					<input type='button' id='add-item-new-button' class='button' style='width:100%' value='Add New Item'>	
					<input type='button' id='add-item-existing-button' class='button' style='width:100%' value='Add Existing Item'>	
				</div>
				<div id='queue-table'>
				<table id='queue-table-content' style='width:100%' cellspacing=0>
					<th>Item Code</th><th>Unit Price</th><th>Quantity</th><th>Amount</th>
					<!-- recurse fetching data from db here 
					<tr><td>1234</td><td>3400</td><td>4</td><td>20000</td></tr>
					-->
					<tr></tr>
					
				</table>
				</div>
			</div>
		<div id='purchase-navigation-container'>
			<div id='queue-item-description' style='height:35%;'>
				<div id='content-sub-title'>Invoice Description</div>
				<b>Invoice ID:</b> <span id='viewer-item-id'></span><br />
				<b>Supplier Name: </b><span id='viewer-supplier-name'></span><br />
				<b>Supplier Address: </b><span id='viewer-supplier-address'></span><br />
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
							Back to Inventory Menu
						</a>
					</li>
					
				</ul>
			</div>
		</div>
		</div>
	</div>
</div>

<!-- jQuery Dialogs -->
<div id='add-item-form'>

   <table cellpadding="2" cellspacing="0" border="0" style='font-family:Corbel;font-size:100%;'>
      <tr>
         <th colspan="4">Add Items in the Inventory!</th>
      </tr>
      <tr>
         <td width="120">Item Name:</td>
         <td colspan="3"><input class="" type="text" id="add-new-item-name-field" style="width: 300px;"></td>
      </tr>
      
<tr>
         <td>Category:</td>
         <td>
			<?php
				echo $category->print_all_category();
			?>
		 </td>
         <td>Quantity:</td>
         <td colspan="3"><input class="" type="text" id="add-new-quantity-field" style="width: 80px;"></td>
      <tr>
         <td>Description:</td>
         <td colspan="3"><input class="" type="text" id="add-new-description-field" style="width: 300px;"></td>
      </tr> 
<tr><td>Purchasing Price:</td>
         <td><input class="" type="text" id="add-new-price-field" style="width: 150px;">
          </tr>

          <tr>
         <td colspan="4" align="right">
			<input type="button" id='add-new-add-item-button' class='buttons' value="Add Item" >
			<input type="reset"  id='add-new-reset-field-button'class='buttons' value="Reset Fields" >
			<input type="button" id='add-new-close-dialog-button' class='buttons' value="Close Dialog" >
		</td>
      </tr>
   </table></form>
</div>

</div>

<div id='setSupplierForm'>
	Please enter the supplier for these items.<br />
	<div id='error-message-manager-supplier-form' class="ui-state-error ui-corner-all" align='center' style="padding:0.7 em;color:red;width:95%"> 
		Please enter a supplier.
	</div>
	<input type='text' id='supplier-field' style='width:100%'/>
</div>

<div id='add-item-existing-form'>
	<div style='border-bottom:1px dotted white'>
		Search for an Item:
		<input type='text' id='search-for-existing-field' />
		<input type='button' class='button' id='search-for-existing-item' value='Search for Item' />
	</div>
	<div style='border-bottom:1px dotted white'>
		<table style='font-size:100%'>
			<tr><td> Item Code: </td><td id='search-existing-item-id' colspan=3 ></td></tr>
			<tr><td> Item Name: </td><td id='search-existing-item-name' colspan=3 ></td></tr>
			<tr><td> Item Description: </td><td id='search-existing-item-description' colspan=3 ></td></tr>
			<tr><td> Item Category: </td><td id='search-existing-item-category' colspan=3 ></td></tr>
			<tr><td> Current Item Quantity: </td><td id='search-existing-currrent-quantity' colspan=3 ></td></tr>
			<tr><td> Purchase Price: </td><td id='search-existing-item-price-view' colspan=3 ></td></tr>
			<tr><td> Quantity </td><td><input type='text' size=4 id='search-existing-item-quantity' /></td>
			    <td> Purchase Price </td><td><input type='text' id='search-existing-item-price' /></td></tr>
		</table>	
	</div>
	<div id='error-message-add-existing' class="ui-state-error ui-corner-all" align='center' style="padding:0.7 em;color:red;width:95%"> 
		Item Code is not yet filled up. Please search for an item.
	</div>
	<div style='float:right'>
		<input type='button' class='button' id='add-existing-add-item-button' value='Add Item'/>
		<input type='button' class='button' id='add-existing-close-dialog-button' value='Close this Dialog'/>
	</div>
</div>