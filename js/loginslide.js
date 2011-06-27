$(document).ready(function() {
	$("#openid_form").hide();
	
	var openidshowing = 0;
	// Expand Panel
	$("#open").click(function(){
		$("div#panel").slideDown("slow");
	
	});	
	
	// Collapse Panel
	$("#close").click(function(){
		$("div#panel").slideUp("slow");	
	});		
	
	// Switch buttons from "Log In | Register" to "Close Panel" on click
	$("#toggle a").click(function () {
		$("#toggle a").toggle();
	});	
	
	$("#showopenid").click(function () {
		if (openidshowing == 0) { 
			$("#openid_form").show("slow");
			openidshowing = 1;
		} else { 
			$("#openid_form").hide("slow");
			openidshowing = 0;
		}
	});		
		
});