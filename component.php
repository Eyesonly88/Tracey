<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/scripts/includes/sessions.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sql_projectfunctions.php');
confirmLogin();
?>

<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8">
		<title>Create Component</title>
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
			$(function() {
				$( "#project-datepicker" ).datepicker();
			});

		</script>
	</head>
	<body class="custom">
		<!-- Body here -->
		<div id="componentwrap">
			<h3>Create New Component</h3>
			<div id="createcomponent-info-container">
				<div id="component-info">
					<label>
						<p>
							Component Name:
						</p>
						<input type="text" name="projectname" id="createproject-name" value=""/>
					</label>
					<label>
						<p>
							Select Project:
						</p>
						<select name="projectid" id="projectid-selector">
							<?php
							$resultSet = getProjectsByEmail($_SESSION['email']);
							foreach($resultSet as $result) {
								echo "<option value=\"" . $result['ProjectId'] . "\">" . $result['ProjectName'] . "</option>";
							}
							?>
						</select>
					</label>
					<label>
						<p>
							Required Hours:
						</p>
						<input type="text" name="requiredhours" id="requiredhours" value=""/>
					</label>
					<label>
						<input type="hidden" name="projectLeaderEmail" id="projectLeader-email" value="<?php echo $_SESSION['email'];?>" />
						<input type="button"  name="submit" value="Create" id="crtcomponent-button" />
						<p id="confirm-inv-msg"></p> </label>
				</div>
			</div>
		</div>
	</body>
</html>
