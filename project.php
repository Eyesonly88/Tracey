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
<html>
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
		<script src="js/jquery.ui.button.js"></script>
		<script>
		
	$(document).ready( function() {
		
			$( "#project-datepicker" ).datepicker();
			$('#createconfirm_btn').click(function(){
				
				var name = $('#createproject-name').val();
				var type = $('#projecttype').val();
				var hours = $('#projecthours').val();
				var due = $('#project-datepicker').val();
				var leader = $('#projectLeader-email').val();
				$.ajax({
					  	   cache: "false",
						   type: "POST",
						   url: "scripts/project/createProject.php",
						   data: "name="+name+"&email="+leader+"&type="+type+"&hours="+hours+"&due="+due,
						   
						  	success: function(msg){
						  		//alert(msg);
							  	if (msg == 1){
							     	$("#projectwrap").hide("slow");
							     	$("#statusinfo").append("<h2> Changes Saved. </h2><BR />");
							     	$("#statusinfo").show("slow");
								} else {
									$("#projectwrap").hide("slow");
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

	<body>
		
		<!-- Body here -->
		<div id="projectwrap">
			<h3>Create New Project</h3>
			<div id="createproject-info-container">
				
				<div id="project-info">
					<label><p>Project Name:</p>
						<input type="text" name="projectname" id="createproject-name" value=""/>
					</label>
					
					<label><p>Project Type:</p>
						<select name="project-type" id="projecttype">
						<?php 
							foreach ($projecttypes as $result){				
								echo "<option value=\"" . $result['Id'] ."\" selected>" . $result['name'] . "</option>";
							} 
						?>
						</select>
							
					
					</label>
					
					<label>Estimated Hours required:
						<input type="text" name="estimatedhours" id="projecthours" />
					</label>
					<label><p>Project Due Date:</p>
						<input type="text" name="projectduedate" id="project-datepicker" />
					</label>
					<label>
						<input type="hidden" name="projectLeaderEmail" id="projectLeader-email" value="<?php echo $_SESSION['email']; ?>" />
						<input type="button" id="createconfirm_btn" name="submit" value="Create Project" />
						<p id="confirm-inv-msg"></p>
					</label>
				</div>
			</div>

		</div>
		<div id="statusinfo"></div>

	</body>
</html>
