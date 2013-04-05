<script type='text/javascript'>
	$(function() {
		$('#content-container').show('drop', 800);
		$('#confirm-exit-dialog')
			.dialog({
				autoOpen:false, modal:true,
				show:"fold", hide:"fold",
				buttons:{
					OK: function(){
						window.open('?', '_self');
					},
					Cancel: function(){
						$(this).dialog("close");
					}
				}
			});
	});
	
	function go_back_to_financial_main(){
		$('#confirm-exit-dialog').dialog('open');
	}
	
</script>
<div id='content-container' align='center'>
	<div id='content' align='left' class='rounded-corners'>
		<div id='content-title'>
			Cash Register
		</div>
		<div id='content-menu-buttons'>
			<ul class='ui-widget ui-helper-clearfix'>
				<li><a href='Javascript:go_back_to_financial_main()'>Back to Financial Menu&nbsp </a></li>
			</ul>
		</div>
		
		<div id='cash-register'>
			
				<div id='content-title'>
					Add Item Form
				</div>
				<div style='margin-top:5px;'>
					Input Choices: 
					<input type='radio' id='is-using-barcode' /> Use Barcode Reader
					<input type='radio' id='is-using-barcode' /> Enter Manually
					
					<div style='margin-top:10px;'>
						fs
					</div>
				</div>
				

				
				<div id='content-title'>
					Purchase Item Queue
				</div>

				
			<div id='content-title'>
				Transaction Options
			</div>
		
		</div>
		
		<!--
		<div id='content-table'>
			<div id='content-table-nav'>
				Previous | Next
			</div>
			<table cellspacing=0>
				<th> Item Code </th><th>Item Name </th>
				<th> Item Description</th><th> Item Quantity </th><th> Date Added </th>
				<tr>
					<td> 1234 </td><td> fsdk </td><td> fsdk </td><td> fsdk </td><td> fsdk </td>
				</tr>
				<tr>
					<td> 3913 </td><td> fsdk </td><td> fsdk </td><td> fsdk </td><td> fsdk </td>
				</tr>
				<tr>
					<td> 3332 </td><td> fsdk </td><td> fsdk </td><td> fsdk </td><td> fsdk </td>
				</tr>
				<tr>
					<td> fsdk </td><td> fsdk </td><td> fsdk </td><td> fsdk </td><td> fsdk </td>
				</tr>
				<tr>
					<td> fsdk </td><td> fsdk </td><td> fsdk </td><td> fsdk </td><td> fsdk </td>
				</tr>
				<tr>
					<td> fsdk </td><td> fsdk </td><td> fsdk </td><td> fsdk </td><td> fsdk </td>
				</tr>	
				<tr>
					<td> fsdk </td><td> fsdk </td><td> fsdk </td><td> fsdk </td><td> fsdk </td>
				</tr>
				<tr>
					<td> fsdk </td><td> fsdk </td><td> fsdk </td><td> fsdk </td><td> fsdk </td>
				</tr>
				<tr>
					<td> fsdk </td><td> fsdk </td><td> fsdk </td><td> fsdk </td><td> fsdk </td>
				</tr>
				<tr>
					<td> fsdk </td><td> fsdk </td><td> fsdk </td><td> fsdk </td><td> fsdk </td>
				</tr>
			</table>
			<div id='table-info'>
				Showing 12 items (1-12) in total of 450 items.
			</div>
		</div>
		
		-->
	</div>
</div>

<!-- jQuery Dialogs -->
<div id='confirm-exit-dialog' class='dialog-content' title='Confirm Exit from Cash Register' >
	<p>
		Are you sure you want to exit from the cash register? Remember, <i>your current transaction will be voided.</i>
	</p>
</div>
<!-- End jQuery Dialog -->