$(document).ready(function() {
	$("#openid_form").hide();
	$("#about").hide();
	$("#contributors").hide();
	
	var openidshowing = 0;
	var	moreinfoshowing = 0;

	
	$("#moreinfo").click(function () {
		if (moreinfoshowing == 0) { 
			$("#about").show("slow");
			$("#contributors").show("slow");
			moreinfoshowing = 1;
		} else { 
			$("#about").hide("slow");
			$("#contributors").hide("slow");
			moreinfoshowing = 0;
		}
	});		
		
});