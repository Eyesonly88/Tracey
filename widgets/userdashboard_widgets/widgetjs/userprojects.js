$(document).ready(function() {
	$("#createproject_form").hide();

	var createProjectFormVisible = 0;
	

	
	$("#createproject_btn").click(function () {
		if (createProjectFormVisible == 0) {
			$("#createproject_form").show("slow");
			createProjectFormVisible = 1;
		} else {
			$("#createproject_form").hide("slow");
			createProjectFormVisible = 0;
		}
	});		
		
});