<?php

#widget that displays issues assigned to a user

include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sessions.php');


?>

	<head>
		<link rel="stylesheet" type="text/css" href="css/customStyle.css" />
		<link rel="stylesheet" type="text/css" href="css/dashboardui.css" />
		<link rel="stylesheet" type="text/css" href="libraries/dashboard/themes/default/jquery-ui-1.8.2.custom.css" />
		<script type="text/javascript" src="libraries/dashboard/lib/jquery-1.4.2.min.js"></script>
		<script type="text/javascript" src="libraries/dashboard/lib/jquery-ui-1.8.2.custom.min.js"></script>

		<script src="js/jquery.hoverIntent.js"></script>
		<script src="js/loginpanel.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			//alert("BLA!");
			//$('#issuewrap').hide();
			$('#contents111').click(function(){
				alert("blakbldsagflsdfg");
			
			});
			//$('#test123').append("HELLO");
			
			//alert("BLA!");
			});
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



<button id="contents111">HELLO</button>

<div id="test123"></div>

</div>

