<?php

include_once ($_SERVER['DOCUMENT_ROOT'] . '/scripts/includes/sessions.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sql_issuefunctions.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sql_userfunctions.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sql_projectfunctions.php');

confirmLogin();

$action = '';

if (isset($_GET['action'])){
	if ($_GET['action'] = 'create'){	
		$action = 1;
	}	
}


$projecttypes = getAllProjectTypes();
?>

<!DOCTYPE html>

<head>
	
	<meta http-equiv="content-type" content="text/html; charset=utf-8">
		<title>Create Project</title>

		<link rel="stylesheet" type="text/css" href="css/customStyle.css" />
		<link rel="stylesheet" type="text/css" href="css/jquery-ui-1.8.15.custom.css" />
		<script type="text/javascript" src="libraries/dashboard/lib/jquery-1.4.2.min.js"></script>
		<script type="text/javascript" src="libraries/dashboard/lib/jquery-ui-1.8.2.custom.min.js"></script>
		<script src="js/jquery.hoverIntent.js"></script>
		<script src="js/loginpanel.js"></script>
		<script src="js/jquery-ui-1.8.15.custom.min.js"></script>
		<script src="js/jquery.ui.core.js"></script>
		<script src="js/jquery.ui.widget.js"></script>
		<script src="js/jquery.ui.datepicker.js"></script>
		<script>
		
	$(document).ready( function() {
		
			$('#project-duedate').datepicker();
			$('#createconfirm_btn').click(function(){
				
				var name = $('form #project-name').val();
				var type = $('form #project-type').val();
				var hours = $('form #project-estimatedhours').val();
				var due = $('form #project-duedate').val();
				var leader = $('form #projectLeader-email').val();
				$.ajax({
					  	   cache: "false",
						   type: "POST",
						   url: "scripts/project/createProject.php",
						   data: "name="+name+"&email="+leader+"&type="+type+"&hours="+hours+"&due="+due,
						   
						  	success: function(msg){
						  		//alert(msg);
							  	if (msg == 1){
							     	$(".box").hide("slow");
							     	$("#statusinfo").append("<h2> Changes Saved. </h2><BR />");
							     	$("#statusinfo").show("slow");
								} else {
									$(".box").hide("slow");
							     	$("#statusinfo").append("<h2> Something went horribly wrong: " + msg + "</h2><BR />");
							     	$("#statusinfo").show("slow");
								}
						    // setupFlexTable2();
						          
						   }
					   
					 	});
			
			});
		});	
			
		</script>
	
</head>
<body style="overflow: hidden">
	<form>
		<input type="hidden" name="projectLeaderEmail" id="projectLeader-email" value="<?php echo $_SESSION['email']; ?>" />
		<div class="box">
			<fieldset class="tabular">
				<legend>
					Create New Project
				</legend>
				<div id="attributes">
					<p>
						<label for="project-name">Project Name<span class="required"> *</span></label>
						<input type="text" id="project-name" required="required" style="width: 400px"/>
					</p>
					<p>
						<label for="project-type">Select Project<span class="required"> *</span></label>
						<select id="project-type" required="required">
							<?php 
								foreach ($projecttypes as $result){				
									echo "<option value=\"" . $result['Id'] ."\" selected>" . $result['name'] . "</option>";
								} 
							?>
						</select>
					</p>
					<p>
						<label for="project-estimatedhours">Estimated Hours Needed</label>
						<input type="text" id="project-estimatedhours"/>
					</p>
					<p>
						<label for="project-duedate">Select Due Date</label>
						<input type="text" id="project-duedate"/>
					</p>
				</div>
			</fieldset>
			<input type="button" id="createconfirm_btn" name="submit" value="Create Project" style="margin-top:1em;"/>
		</div>
		<div id="statusinfo" type="hidden" style="text-align: center;font-size:3em;color: white"></div>
	</form>
</body>