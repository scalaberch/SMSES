$(function () {
	$('.button').button();
	
	$('#menu li')
		.click(function () 
		{
			var id = $(this).attr("id");
			var location = "";
			
			if (isEqual(id, "finance-cash-register")){
				location = '?register';
			}
			else if (isEqual(id, "finance-forecast-status")){
				location = '?forecast';
			}
			else if (isEqual(id, "inventory-back")){
				location = '/SMSES';
			} 
			
			window.open(location, '_self');
		}
	);
	

});

function isEqual(another, other){
	return another == other;
}