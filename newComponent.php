<?php // Add php scripts here

include_once($_SERVER['DOCUMENT_ROOT'] . '/scripts/includes/sessions.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sql_projectfunctions.php');
confirmLogin();

?>

<!DOCTYPE html>

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
</head>
<body>
	<form>
		<input type="hidden" name="projectLeaderEmail" id="projectLeader-email" value="<?php echo $_SESSION['email'];?>" />
		<div class="box">
			<fieldset class="tabular">
				<legend>
					Create New Component
				</legend>
				<div id="attributes">
					<p>
						<label for="component-name">Component Name<span class="required"> *</span></label>
						<input type="text" id="component-name" required="required" style="width: 400px"/>
					</p>
					<p>
						<label for="component-projectlist">Select Project<span class="required"> *</span></label>
						<select id="component-projectlist" required="required">
							<?php
							$resultSet = getProjectsByEmail($_SESSION['email']);
							foreach($resultSet as $result) {
								echo "<option value=\"" . $result['ProjectId'] . "\">" . $result['ProjectName'] . "</option>";
							}
							?>
						</select>
					</p>
					<p>
						<label for="component-requiredhours">Required Hours</label>
						<input type="text" id="component-requiredhours"/>
					</p>
				</div>
			</fieldset>
			<input type="button" value="Create Component" id="confirm_btn" style="margin-top:1em;/>
		</div>
		<div id="statusinfo" type="hidden" style="text-align: center;font-size:3em;color: white"></div>
	</form>
</body>