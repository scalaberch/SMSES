<script type='text/javascript'>
	$(function () {
		$('#error-message-manager-inventory').hide(0);
	});

</script>

<div id='content-container' align='center'>
	<div id='content' align='left' class='rounded-corners'>
		<div id='content-title'>
			Inventory Management
		</div>
		<div id='content-menu-buttons'>
			<ul class='ui-widget ui-helper-clearfix'>
				<li><a href='Javascript:open_search_item_dialog()'>Search for an Item&nbsp </a></li>
				<li><a href='?inventory&add'>Add New Item&nbsp </a></li>
			<!-- Javascript:open_add_item_dialog() -->
				<li><a href='?'>Back to Menu&nbsp </a></li>
			</ul>
		</div>
		
		
		<div id='content-table'>
			
		</div>
	</div>
</div>

<!-- jQuery Dialogs -->
<div id='search-item-dialog' class='dialog-content' title='Search for an Item' >
	<div style='border-bottom:1px dotted white;padding-bottom:3px;'>
		Enter item name here:
		<input type='text' id='search-item-field'/>
		<input type='button' id='check-item-button' class='button' value='Check Item Information' />
	</div>
	<div style='margin-top:10px' id='item-search-table' style=''>
		<div id='error-message-manager-inventory' class="ui-state-error ui-corner-all" align='center' style="padding:0.7 em;color:red;"> 
			Item is not in the database.
		</div>
		<table>
			<th>Item ID</th><th>Item Name</th><th>Item Description</th>
			<tr>
				<td id='search-item-field-id'></td><td id='search-item-field-name'></td>
				<td id='search-item-field-description'></td>
			</tr>
		</table>
		<div align='right'>
			<input type='button' id='view-selected-item-button' class='button' disabled='disabled' value='View Selected Item Information' />
		</div>
	</div>
</div>

<div id='item-information-dialog' class='dialog-content' title='' >
	<div id='loading' align='center'>
		<table cellspacing=10 ><tr><td>
			<img src='../lib/img/load.gif' />
		</td><td>
			<span style='font-size:250%; color:grey;'>Loading...</span>
		</td></tr></table>
	</div>
</div>
<!-- End jQuery Dialog -->