$(function () {
	$('.button').button();
	
	$('#menu li')
		.click(function () 
		{
			var id = $(this).attr("id");
			var location = "";
			
			if (isEqual(id, "inventory-search-item")){
				location = '?search';
			}
			else if (isEqual(id, "inventory-manage-inventory")){
				location = '?inventory';
			}
			else if (isEqual(id, "inventory-manage-suppliers")){
				location = '?suppliers';
			} 
			else if (isEqual(id, "inventory-back")){
				location = '/SMSES';
			} 
			
			window.open(location, '_self');
		}
	);
	

});

function travel_to_submenu(type){
	if (isEqual(type, "")){
		
	}
}

function isEqual(another, other){
	return another == other;
}