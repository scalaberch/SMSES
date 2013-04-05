$(function () {
	$('.button').button();
	
	$('#menu li')
		.click(function () 
		{
			var id = $(this).attr("id");
			var location = "";
			
			if (isEqual(id, "report-financial")){
				location = '?finance';
			}
			else if (isEqual(id, "report-inventory")){
				location = '?inventory';
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