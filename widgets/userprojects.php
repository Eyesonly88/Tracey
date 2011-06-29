<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sessions.php');


?>
<script src="/widgets/widgetjs/userprojects.js" type="text/javascript"></script>
<script type="text/javascript">
  
  var currentUser = "";
  getCurrentUser();
  function setUser(msg){ 
  	currentUser = msg;	
  }
  
  
  function createProject() { 
  
  	var projectName = document.getElementById('name').value;
  	var user = currentUser;
 
  	$.ajax({
  	   cache: "false",
	   type: "POST",
	   url: "scripts/project/createProject.php",
	   data: "name="+projectName+"&user="+user,
	   success: function(msg){
	     getUserProjects(user);
	   }
   
 	});

  
  }
  
  function getUserProjects(user){
  	$.ajax({
  	   cache: "false",
	   type: "POST",
	   url: "/scripts/userdashboard/getCreatedProjects.php",
	   data: "email="+user,
	   success: function(msg2){
	     $("#projectlist").empty();
	     $("#projectlist").append(msg2);
	   }
   
 	});
  }
  
  function getCurrentUser(){
  	$.ajax({
  	   cache: "false",
	   type: "POST",
	   url: "/scripts/authentication/getCurrentUser.php",
	   success: function(msg){
	     setUser(msg);
	   }
   
 	});
  }
  
  function getCreatedProjects() {
  $.ajax({
  	   cache: "false",
	   type: "POST",
	   url: "/scripts/authentication/getCurrentUser.php",
	   success: function(msg){
	     $("#title").append("<h4>Projects related to User: " + msg + "</h4>");
	     setUser(msg);
	     getUserProjects(msg);
	   }
   
 	});
 }
 
 getCreatedProjects();
	

	
</script>

<style>
  h5 span {
    color:#666666;
    float:right;
    font-size:0.8em;
    font-weight: normal;
  }

  h5 {
    border-top:1px solid #DDDDDD;
    border-bottom:1px solid #DDDDDD;
    color:#222222;
    padding-left:3px;
    padding-right:3px;
    margin-top:3px;
    margin-bottom:3px;
    background-color:#eeeeee;
  }
  .default {
    font-style:italic;
  }
  .default-value {
    font-size:80%;
  }
  pre {
    border: 1px dashed #aaaaaa;
    padding:5px;
    margin-top:5px;
    margin-bottom:5px;
  }

</style>

<div id="contents">
<div id="title"></div>
<div id="projectlist"></div>
	<div id="createproject_btn"><h4><a href="#">Create Project</a></h4></div>
			<div id="createproject_form">
				<form action="" method="post">
					<h1>Create a Project</h1>
					<label class="grey" for="name">Name:</label>
					<input class="field" type="text" name="name" id="name" value="" size="23" />
        			<div class="clear"></div>
					<input type="button" onclick="createProject()" name="submit" value="Go" class="project_submit" />
				</form> 		
			</div>
</div>
