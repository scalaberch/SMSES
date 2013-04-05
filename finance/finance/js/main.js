$(function () {
	$('.button').button();
	
	$('#menu li')
		.click(function () 
		{
			var id = $(this).attr("id");
			var location = "";
			
			hide_submenu_pane();
			if (isEqual(id, "finance-cash-register")){
				location = '?register';
			}
			else if (isEqual(id, "finance-forecast-status")){
				location = '?forecast';
			}
			else if (isEqual(id, "inventory-back")){
				location = '/SMSES';
			} 
			
			setTimeout( function () { window.open(location, '_self'); }, 800);
			
		
		
		}
	);
	

});

function hide_submenu_pane() {
	$('#sub-menu').hide('drop', 1000);
}

function travel_to_submenu(type){
	if (isEqual(type, "")){
		
	}
}

function isEqual(another, other){
	return another == other;
}