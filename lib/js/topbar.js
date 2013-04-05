$(function (){
	startTime();
});

function startTime() {
	var today=new Date(); var isAMoPM = " AM";
	var h=today.getHours(); var m=today.getMinutes(); var s=today.getSeconds();
	// add a zero in front of numbers<10
	m=checkTime(m); s=checkTime(s);
	//document.getElementById('txt').innerHTML="<b>Time is:</b>"+h+":"+m+":"+s;
	
	if (h == 0){
		h = 12;
	}
	else if (h >= 13){
		isAMoPM = " pm";
		h = h-12;
	}
	
	var string = "<span id='clock'>"+h+":"+m+":"+s+isAMoPM+"</span>";
	$('#clock').remove(); $('#myclock').append(string);
	t=setTimeout('startTime()',500);
}

function checkTime(i) {
		
	if (i<10) {
		i="0" + i;
	}
	return i;
}