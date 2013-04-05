<script type='text/javascript'>
	$(function() {
		$('#content-container').show('drop', 800);
		$('#search-item-dialog')
			.dialog({
				autoOpen:false, modal:true,
				show:"fold", hide:"fold"
			});
	});
	
	function open_search_item_dialog(){ $('#search-item-dialog').dialog('open'); }
	
</script>
<div id='content-container' align='center'>
	<div id='content' align='left' class='rounded-corners'>
		<div id='content-title'>
			Inventory Management
		</div>
		<div id='content-menu-buttons'>
			<ul class='ui-widget ui-helper-clearfix'>
				<li><a href='Javascript:open_search_item_dialog()'>Search for an Item&nbsp </a></li>
				<li><a href='#'>Add New Item&nbsp </a></li>
				<li><a href='#'>Back to Menu&nbsp </a></li>
				<!--
				<li>
					<a href='?' class='button'>
						<span class="ui-icon ui-icon-circle-triangle-w"></span>
					</a>
				</li>
				-->
			</ul>
		</div>
		
		
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
	</div>
</div>

<!-- jQuery Dialogs -->
<div id='search-item-dialog' class='dialog-content' title='Search for an Item' >
	<div style='border-bottom:1px dotted white;padding-bottom:3px;'>
		Enter item name here:
		<input type='text' />
		<input type='button' id='check-item-button' class='button' value='Check Item Information' />
	</div>
	<div>
	
	
	</div>
</div>
<!-- End jQuery Dialog -->