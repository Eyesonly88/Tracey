<?php
// insert the php functions needed here
?>

<!DOCTYPE html>
<head>
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
				<link rel="stylesheet" href="/libraries/shadowbox/shadowbox.css" type="text/css">
		<script src="/libraries/shadowbox/shadowbox.js" type="text/javascript"></script>
	<script>
		$(document).ready(function() {
			$( "#issue-startdate" ).datepicker();
			$( "#issue-resolveddate" ).datepicker();
			
			/* This function lets you change the content shown inside a shadowbox to show the content in 'path' */
				Shadowbox.clearCache();
				Shadowbox.init({
						displayNav: false
  				});
		});

	</script>
</head>
<body>
	<form>
		<div class="box">
			<fieldset class="tabular">
				<legend>
					Issue Information
				</legend>
				<div id="attributes">
					<div class="leftcontent">
						<p>
							<label for="issue-status">Status<span class="required"> *</span></label>
							<select id="issue-status" required="required">
								<option value="1" selected="selected">Open</option>
								<option value="2" >Closed</option>
								<option value="3" >In Progress</option>
							</select>
						</p>
						<p>
							<label for="issue-assignee">Assignee<span class="required"> *</span></label>
							<select id="issue-assignee" required="required">
								<option value="1" selected="selected">Select Project Member</option>
								<option value="2" >Mido Basim</option>
							</select>
						</p>
						<p>
							<label for="issue-priority">Priority<span class="required"> *</span></label>
							<select id="issue-priority" required="required">
								<option value="1" >Low</option>
								<option value="2" selected="selected">Normal</option>
								<option value="3" >High</option>
							</select>
						</p>
					</div>
					<div class="rightcontent">
						<p>
							<label for="issue-type">Type</label>
							<select id="issue-type">
								<option value="1" selected="selected">Public</option>
								<option value="2" >Private</option>
							</select>
						</p>
						<p>
							<label for="issue-component">Component</label>
							<select id="issue-component">
								<option value="1" selected="selected">Default</option>
							</select>
						</p>
						<p>
							<label for="issue-startdate">Start Date<span class="required"> *</span></label>
							<input type="text" id="issue-startdate" required="required"/>
						</p>
						<p>
							<label for="issue-resolveddate">Resolved Date</label>
							<input type="text" id="issue-resolveddate"/>
						</p>
					</div>
					<div style="clear:both;"></div>
				</div>
			</fieldset>
			<fieldset class="tabular">
				<legend>
					Issue Description
				</legend>
				<div id="issue-description">
					<textarea accesskey="e" cols="60" rows="10"></textarea>
				</div>
			</fieldset>
			<fieldset class="tabular">
				<legend>
					Log Hours
				</legend>
				<div id="log-issue-hours">
					<p>Click on the log hours button to add the amount of hours you spent on this issue</p>
					<p>
						<a id="loghours" rel="shadowbox[Mixed];height=240" href="logissuehour.php?id=150"><input type="button" value="Log Hours" /></a>
					</p>
					
				</div>
			</fieldset>
			
			<input type="submit" value="Save Issue" id="iphonebutton"/>
		</div>
	</form>
</body>