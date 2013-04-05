<script type='text/javascript'>
	$(function() {
		$('#content-container').show('drop', 1000);
	});
</script>
<div id='content-container' align='center'>
	<div id='content' align='left' class='rounded-corners'>
		<div id='content-title'>
			Cash Drawer
		</div>
		<div id='content-menu-buttons'>
			<a href='?'>Back to Inventory Menu&nbsp </a>
		</div>
		<div style='margin:3%;'>
		<div id='queryform' style='float:left;width:70%;'>
		<table class='ui-widget ui-helper-clearfix'>
			<tr><td>Item number: </td><td>
				<input type='text' />
			</td>
			<td>Quantity: </td><td>
				<input type='text' style='width:50%;' />
			</td></tr>
		</table>
		<div id='content-table'>
		<table style='width:80%' cellspacing=0>
			<th>item number</th><th>unit price</th><th>quantity</th><th>total amount</th>
			<!-- recurse fetching data from db here -->
			<tr><td>1234</td><td>3400</td><td>4</td><td>20000</td></tr>
			<tr><td>1234</td><td>3400</td><td>4</td><td>20000</td></tr>
			<tr><td>1234</td><td>3400</td><td>4</td><td>20000</td></tr>
			<tr><td>1234</td><td>3400</td><td>4</td><td>20000</td></tr>
			<tr><td>1234</td><td>3400</td><td>4</td><td>20000</td></tr>
			<tr><td>1234</td><td>3400</td><td>4</td><td>20000</td></tr>
			<tr><td>1234</td><td>3400</td><td>4</td><td>20000</td></tr>
			<tr><td>1234</td><td>3400</td><td>4</td><td>20000</td></tr>
			<tr><td>1234</td><td>3400</td><td>4</td><td>20000</td></tr>
		</table>
		</div>

		
		</div>
		<div id='buttons'>
			<div id='item_description' style='height:35%;'>
				item name: haytem daw oh!<br />item description: blahh blahh blahh
			</div>
			<div>
				<ul>
					<li>
						all item amount: 180000
					</li>
					<li>
						<a href='?' >purchase</a>
					</li>
				</ul>
			</div>
		</div>
		</div>
	</div>
</div>

<!-- jQuery Dialogs -->

<!-- End jQuery Dialog -->