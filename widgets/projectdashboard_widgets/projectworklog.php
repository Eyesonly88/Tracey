<?php

#widget that displays issues related to a project

include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sessions.php');


?>
<head>
<link rel="stylesheet" href="/libraries/datatables/media/css/demo_table_jui.css" type="text/css">
<!--<script src="/libraries/flexigrid/js/flexigrid.js" type="text/javascript"></script> -->
<script src="/libraries/dataTables/media/js/jquery.dataTables.js" type="text/javascript"></script>
<link rel="stylesheet" href="/libraries/shadowbox/shadowbox.css" type="text/css">
<script src="/libraries/shadowbox/shadowbox.js" type="text/javascript"></script>
<script type="text/javascript">
  
  
   Shadowbox.init({
		
   		displayNav: "false",
   		displayCounter: "false"
  	});
  	Shadowbox.clearCache();
  
  //alert(issuehtml);
  var projectid = $('#projectid').val();
  var currentUser = "";
  
  initialSetup4();
  
 
  function setUser(msg){ 
  	currentUser = msg;	
  }
  
  function setupFlexTable3(){
  	
  	/* Apply datatable library to the list of tables. */
  	$('#loglist').dataTable({
  		
  		"bPaginate": false,
		"bLengthChange": false,
		"bFilter": true,
		"bSort": true,
		"bInfo": false,
		"bAutoWidth": false,
		"bStateSave": true, 
		"bDestroy": true,
		"oSearch": {"sSearch": ""}
  	
  	});
  	//$("#projectlist").fnDraw();
  }
  

  
  
  /* This is the initial function call that is executed when the widget is ready. 
 	Sets up the initial list of projects. */
  function initUserProjects4(id){
  $.ajax({
  	   cache: "false",
	   type: "POST",
	   url: "/scripts/project/getProjectWorkLog.php",
	   data: "id="+id,
	   success: function(msg2){
	  
	     $("#loglist").empty();
	     $("#loglist").append(msg2);
	     setupFlexTable3();
	     
	   }
   
 	});
  }
  
  /* The first initial function call, which calls 2 other 
 	functions to set up the initial state of the widget*/
  function initialSetup4() {
 
	  initUserProjects4(projectid);
	    
 	}
  



</script>
</head>
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

<div id="contents2">
	<input type="hidden" id="projectid" value=<?php echo $_SESSION['projectid']; ?> />
	<table id="loglist" class="display" ></table>
</div>




