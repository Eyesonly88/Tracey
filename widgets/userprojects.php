<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sessions.php');


?>

<!--<link rel="stylesheet" href="/libraries/flexigrid/css/flexigrid.css" type="text/css"> -->
<link rel="stylesheet" href="/libraries/datatables/media/css/demo_table.css" type="text/css">
<script src="/widgets/widgetjs/userprojects.js" type="text/javascript"></script>
<!--<script src="/libraries/flexigrid/js/flexigrid.js" type="text/javascript"></script> -->
<script src="/libraries/dataTables/media/js/jquery.dataTables.js" type="text/javascript"></script>


<script type="text/javascript">
  
  var currentUser = "";
  getCurrentUser();
  initialSetup();
  
  $('.project_submit').click(function(){ 
  	createProject();
  })
  function setUser(msg){ 
  	currentUser = msg;	
  }
  
  function setupFlexTable(){
  	/*$('.projlistflex').flexigrid({
  	
  	 colModel : [
                        {display: 'ID', name : 'p_id', width : 40, sortable : true, align: 'left'},
                        {display: 'Name', name : 'p_name', width : 150, sortable : true, align: 'left'},
                        {display: 'Type', name : 'p_type', width : 150, sortable : true, align: 'left'},
                 		{display: 'Dashboard Link', name : 'p_dashboard_button', width : 100, sortable : true, align: 'center'},
                ],
       
        sortname: "p_id",
        sortorder: "asc",
        title: "Projects Created by " + currentUser,

		   showTableToggleBtn: false,

  		resizable: false,
        width: 490,
        height: 'auto',
        singleSelect: true

  	
  	});*/
  	
  	$('#projectlist').dataTable({
  		
  		"bPaginate": false,
		"bLengthChange": false,
		"bFilter": true,
		"bSort": false,
		"bInfo": false,
		"bAutoWidth": false,
		"bStateSave": true 
		
  	
  	});
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
	     $('#projectlist').fnDraw();
	     
	     $(".p_dashboard_button").click(function() { 
	     	
	     	$(this).empty();
	     	$(this).append("Redirecting...");
	     
	     });
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
  
  function initialSetup() {
  $.ajax({
  	   cache: "false",
	   type: "POST",
	   url: "/scripts/authentication/getCurrentUser.php",
	   success: function(msg){
	     setUser(msg);
	     getUserProjects(msg);
	     setupFlexTable();
	   }
   
 	});
 }
	
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
<table id="projectlist" class="display" ></table>
	
</div>
<BR /><BR />
<div id="createproject_btn"><h4><a href="#">Create Project</a></h4></div>
			<div id="createproject_form">
				<form action="" method="post">
					<h1>Create a Project</h1>
					<label class="grey" for="name">Name:</label>
					<input class="field" type="text" name="name" id="name" value="" size="23" />
        			<div class="clear"></div>
					<input type="button"  name="submit" value="Go" class="project_submit" />
				</form> 		
			</div>