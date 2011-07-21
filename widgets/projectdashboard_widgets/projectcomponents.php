<?php

# Widget that displays the components that are a part of a project

include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sessions.php');


?>

<script type="text/javascript">
  
	
	var projectid = $('#projectid').val();
	//alert(projectid);
	
 

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
	
	<h4>Components:</h4>
	<input type="hidden" id="projectid" value=<?php echo $_SESSION['projectid']; ?> />
	<div id="title"></div>
	<table id="componentlist" class="display" ></table>

</div>


	

<BR /><BR />