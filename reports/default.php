
<div id='sub-menu' align='center'>
		<div id='menu' align='left'>
<script type='text/javascript'>
	$.ajax({ url:"sessionteller.php?position", datatype: "html",
		success: function (data) {
			if (data == 'Supervisor'){
				$('#report-financial').remove();
			}
			else{
				$('#report-inventory').remove();
			}
		}
	});
</script>
			<ul>
				<li id='report-financial'>
					<img src='../lib/img/menu-icons/cash_report.png' style='float:left;margin-right:8px;'/>
					Financial Reports
				</li>
				<li id='report-inventory'>
					<img src='../lib/img/menu-icons/inventory_report.png' style='float:left;margin-right:8px;'/>
					Inventory Reports
				</li>
				<li id='inventory-back'> 
					<img src='../lib/img/small/back.png' style='float:left;margin-right:8px;'/>
					Go back to Dashboard
				</li>
			</ul>
		</div>
		<div id='sub-menu-text' align='left'>
			<img src='../lib/img/icon/reports.png' style='float:left'/>
				<div class='sub-menu-text-main'>
					reports
				</div>
				report generation sub-menu				
		</div>
	</div>