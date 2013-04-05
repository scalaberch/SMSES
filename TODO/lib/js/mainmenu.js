$(function (){
			//Initialize the Clock
			//var clock = new Clock();

			
			//$('#sub-menu').hide(0);
			$('.main-menu-buttons')
				.mouseenter(function (){$(this).css('background-image', 'url(/18series/img/dark-transparent.PNG)');})
				.mouseleave(function () {$(this).css('background-image', 'none');})
				.click(function () {
					$('#menu').hide('drop', 1000);
					var the_id = $(this).attr("id"),
						location = "elements/submenu.php?",
						loc_text = "";
						
					if (the_id == 'main-menu-inventory'){
						loc_text = "Inventory Menu";
						location = location + "inventory";
					}
					else if (the_id == "main-menu-finance"){
						loc_text = "Finance Menu";
						location = location + "finance";
					}
					else if (the_id == "main-menu-reports"){
						loc_text = "Reports Generation Menu";
						location = location + "report";
					}
					else if (the_id == "main-menu-others"){
						loc_text = "Other Functions Menu";
						location = location + "others";
					}
					//alert(location);
					$('#location').html(loc_text);
					$.ajax({
						url: location,
						datatype:"html",
						success: function (data) {
							$('#sub-menu')
								.append(data)
								.show(1000);
							
						}
					});	
				});
				
				
		});
		
function goBackToMainMenu(){
	$("#submenu").hide(1000);
	setTimeout(function() { $("#mainmenu").show(1000);}, 1000);
}