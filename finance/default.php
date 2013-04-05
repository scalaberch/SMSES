<div id='sub-menu' align='center'>
		<div id='menu' align='left'>
<script type='text/javascript'>
	$.ajax({ url:"sessionteller.php?position", datatype: "html",
		success: function (data) {
			if (data == 'Cashier'){
				$('#finance-forecast-status').remove();
			}
			else{
				$('#finance-cash-register').remove();
			}
		}
	});
</script>
			<ul>
				<li id='finance-cash-register'>
					<img src='../lib/img/menu-icons/cash_reg.png' style='float:left;margin-right:8px;'/>
					Cash Register
				</li>
				<li id='finance-forecast-status'>
					<img src='../lib/img/menu-icons/forecast.png' style='float:left;margin-right:8px;'/>
					Forecast Financial Status 
				</li>
				<li id='inventory-back'> 
					<img src='../lib/img/small/back.png' style='float:left;margin-right:8px;'/>
					Go back to Dashboard
				</li>
			</ul>
		</div>
		<div id='sub-menu-text' align='left'>
			<img src='../lib/img/icon/financial.png' style='float:left'/>
				<div class='sub-menu-text-main'>
					finance
				</div>
				financial management				
		</div>
	</div>