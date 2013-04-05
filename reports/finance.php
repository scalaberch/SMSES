<style>
	.ui-autocomplete {
		max-height: 200px;
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
		height: 200px;
	}
	
	/* Override background...
	*/
	
	#content {
		height:100%;
	}
	</style>
<script type='text/javascript'>
	$(function() {
		//Initiator
		
		var today = new Date(); var month = "";
			
		if (today.getMonth() < 10){
			month = "0"+today.getMonth();
		}
		
		var year = "<?php echo date("Y"); ?>";
		var	now = year + "-" + month + "-" + today.getDate();
		
		$('#sales-report-daily-field').val(now);
		$('#sales-report-yearly-field, #sales-report-monthly-field').hide(0);
		$('#error-message-ledger-report, #error-message-sales-report, #error-message-income').hide(0);
		/*
		$.ajax({
			url:"ajax/search.php?set",
			datatype:"html", type:"POST",
			data: {
				setting:"name"
			}
		});
		*/
		
		//Report Choices Main Menu
		$('#report-choices').accordion({
			autoHeight:false, navigation:true, collapsible:true });
			
		//Report Submit Button
		$('.submit-buttons').button().click(function () {
			var loading = "<div id='loading' align='center'><img src='../lib/img/load.gif' /></div>";
			var id = $(this).attr('id');
			
			if (id == "sales-report-submit-button"){
				var sales_report_type = $('#sales-report-type').val();
				var okay = false;
			
				//Error Catching...
				if (sales_report_type == "Daily"){
					if ( $('#sales-report-daily-field').val() == "Click to show date" || $('#sales-report-daily-field').val() == ""){
						$('#error-message-sales-report').html("Please enter a date.");
						$('#error-message-sales-report').show('fade', 1000);
						setTimeout( function () {
							$('#error-message-sales-report').hide('fade', 1000);
						}, 3000);	
					}
					else { okay = true; }
				}
				else if (sales_report_type == "Monthly"){
					if ( $('#sales-report-monthly-year-field').val() == "" || $('#sales-report-monthly-year-field').val() == 0){
						$('#error-message-sales-report').html("Please enter a year.");
						$('#error-message-sales-report').show('fade', 1000);
						setTimeout( function () {
							$('#error-message-sales-report').hide('fade', 1000);
						}, 3000);	
					}
					else { okay = true; }
				}
				else if (sales_report_type == "Yearly"){
					if ( $('#sales-report-yearly-field').val() == 0 || $('#sales-report-yearly-field').val() == "Enter year"){
						$('#error-message-sales-report').html("Please enter a year.");
						$('#error-message-sales-report').show('fade', 1000);
						setTimeout( function () {
							$('#error-message-sales-report').hide('fade', 1000);
						}, 3000);	
					}
					else { okay = true; }
				}
				
				//Do the report
				var month_day = $('#sales-report-monthly-year-field').val(),
					month_month = $('#sales-report-monthly-month').val(),
					yearly_year = $('#sales-report-yearly-field').val(),
					dailyDay = $('#sales-report-daily-field').val();
				
				if (okay){
					$('#search-result').html(loading);
					$.ajax({
						url:"ajax/finance.php?sales",
						datatype:"html", type:"POST",
						data: {
							timeframe:sales_report_type,
							dailydate: dailyDay,
							monthlydate:month_day,
							monthlymonth:month_month,
							yearlyyear:yearly_year
							
						},
						success: function(data){
							setTimeout( function () {
								$('#loading').remove();
								$('#search-result').html(data).fadeIn(1000);
							}, 1000);
						}
					});
				}
				
			}
			else if (id == 'ledger-form-submit-button'){
				if ($('#ledger-form-start-date').val() == "" || $('#ledger-form-end-date').val() == ""){
					$('#error-message-ledger-report').show('fade', 1000);
					setTimeout(function () {
						$('#error-message-ledger-report').hide('fade', 1000);
					}, 3000);
				}
				else {
					$('#search-result').html(loading);
					var start_date = $('#ledger-form-start-date').val(),
						end_date = $('#ledger-form-end-date').val();
					$.ajax({
						url:"ajax/finance.php?ledger",
						datatype:"html", type:"POST",
						data:{
							startdate:start_date,
							enddate:end_date
						},
						success: function(data){
							setTimeout( function () {
								$('#loading').remove();
								$('#search-result').html(data).fadeIn(1000);
							}, 1000);
						}
					});
				}
			}
			else if (id == "income-form-submit-button"){
				if ($('#income-form-start-date').val() == "" || $('#income-form-end-date').val() == ""){
					$('#error-message-income').show('fade', 1000);
					setTimeout(function () {
						$('#error-message-income').hide('fade', 1000);
					}, 3000);
				}
				else {
					var start_date = $('#income-form-start-date').val(),
						end_date = $('#income-form-end-date').val();
					$('#search-result').html(loading);
					$.ajax({
						url:"ajax/finance.php?income",
						datatype:"html", type:"POST",
						data:{
							startdate:start_date,
							enddate:end_date
						},
						success: function(data){
							setTimeout( function () {
								$('#loading').remove();
								$('#search-result').html(data).fadeIn(1000);
							}, 1000);
						}
					});
				}
			}
		});
		
		//Sales Report Picker
		$('#sales-report-type')
			.change(function () {
				var value = $(this).val();
				//var original_value = "<td colspan=2><input type='text' style='color:grey;width:100%' value='Click to show date' id='sales-report-daily-field' /></td>";
				$('.sales-report-field').hide(0);
				if (value == "Daily"){
					$('#sales-report-daily-field').show(0);
				}
				else if (value == "Monthly"){
					$('#sales-report-monthly-field').show(0);
				}
				else if (value == "Yearly"){
					$('#sales-report-yearly-field').show(0);
				}
		});
		
		//Sales Report: Daily
		$('#sales-report-daily-field')
			.focus( function () {
				$(this).val("");
				$(this).css('color', 'black');
			})
			.blur( function () {
				if ($(this).val() == ""){
					$(this).val("Click to show date");
					$(this).css('color', 'grey');
				}
			})
			.datepicker({ dateFormat:"yy-mm-dd"});
		
		//Sales Report: Yearly
		$('#sales-report-yearly-field')
			.focus( function () {
				$(this).val("");
				$(this).css('color', 'black');
			})
			.blur( function () {
				if ($(this).val() == ""){
					$(this).val("Enter year");
					$(this).css('color', 'grey');
				}
			})
		
		//Ledger Form Datepicker and Income Report Date picker...
		$('#ledger-form-start-date, #ledger-form-end-date, #income-form-start-date, #income-form-end-date')
			.datepicker({ dateFormat:"yy-mm-dd"});
	});
</script>
<div id='content-container' align='center'>
	<div id='content' align='left' class='rounded-corners'>
		<div id='content-title'>
			Generate Financial Report
		</div>
		<div id='content-menu-buttons'>
			<a href='?'>Back to Reports Menu &nbsp </a>
		</div>
		<div id='search-form' style='width:25%;margin-top:3%; float:left;'>
			<div id='report-choices'>
				<h3><a href='#'>Sales Report</a></h3>
				<div>
					<p style='margin-left:-18px;'>
					<table style='font-size:100%;'>
					<tr><td colspan=2>
						<select id='sales-report-type' style='width:100%'>
							<option> Daily </option>
							<option> Monthly </option>
							<option> Yearly </option>
						</select>
					</td></tr>
					<tr>
						<td colspan=2>
							<input type='text' class='sales-report-field' style='color:grey;width:100%' value='Click to show date' id='sales-report-daily-field' />
							<span class='sales-report-field' id='sales-report-monthly-field'>
								<select id='sales-report-monthly-month'>
									<option value='1'>January</option><option value='2'>February</option><option value='3'>March</option>
									<option value='4'>April</option><option value='5'>May</option><option value='4'>June</option>
									<option value='7'>July</option><option value='8'>August</option><option value='9'>September</option>
									<option value='10'>October</option><option value='11'>November</option><option value='12'>December</option>
								</select>
								<input type='text'  style='color:grey;width:40%' id='sales-report-monthly-year-field' value='2000'  />
							</span>
							<input type='text' class='sales-report-field' style='color:grey;width:100%' value='Enter year' id='sales-report-yearly-field' /></td>
					<!-- 	<td>End Date:</td>
						<td><input type='text' id='ledger-form-end-date' size=8 /></td></tr>
					-->
					<tr><td colspan=2 >
						<div id='error-message-sales-report' class='ui-state-highlight ui-corner-all' style='padding:5px'>
							Please fill up all necessary fields.
						</div>
						<input type='button' class='submit-buttons' value='Generate Sales Report' id='sales-report-submit-button' />
					</td></tr>
					</table>
					</p>
				</div>
				<h3><a href='#'>Expense Report</a></h3>
				<div>
					<p style='margin-left:-18px;'>
					<table style='font-size:100%;'><tr><td>
						Start Date:</td><td> <input type='text' id='ledger-form-start-date' size=8 /></td></tr>
						<tr><td>
						End Date:</td><td> <input type='text' id='ledger-form-end-date' size=8 /></td></tr>
						<tr><td colspan=2 >
						<div id='error-message-ledger-report' class='ui-state-highlight ui-corner-all' style='padding:5px'>
							Please fill up start/end dates.
						</div>
						<input type='button' class='submit-buttons' value='Show Expense Report' id='ledger-form-submit-button' />
						</td></tr>
					</table>
					</p>
				</div>
				<h3><a href='#'>Income Statement</a></h3>
				<div>
					<div>
					<p style='margin-left:-18px;'>
					<table style='font-size:100%;'><tr><td>
						Start Date:</td><td> <input type='text' id='income-form-start-date' size=8 /></td></tr>
						<tr><td>
						End Date:</td><td> <input type='text' id='income-form-end-date' size=8 /></td></tr>
						<tr><td colspan=2 >
						<div id='error-message-income' class='ui-state-highlight ui-corner-all' style='padding:5px'>
							Please fill up start/end dates.
						</div>
						<input type='button' class='submit-buttons' value='Show Income Report' id='income-form-submit-button' />
						</td></tr>
					</table>
					</p>
				</div>
				</div>
			
			
			</div>
			<!-- This holds the search key (itemID) -->
			<input type='text' id='search-key' hidden='hidden'/>
		</div>
		
		<div id='search-result' align='left' style='float:right;margin-top:2%;width:74%;'>
			
		</div>
	</div>
</div>

<!-- jQuery Dialogs -->

<!-- End jQuery Dialog -->