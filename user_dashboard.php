
<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sessions.php');

confirmLogin();

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <title>User Dashboard</title>

    <script type="text/javascript" src="libraries/dashboard/lib/jquery-1.4.2.min.js"></script>
    <script type="text/javascript" src="libraries/dashboard/lib/jquery-ui-1.8.2.custom.min.js"></script>
    <script type="text/javascript" src="libraries/dashboard/jquery.dashboard.js"></script>
    <script type="text/javascript" src="libraries/dashboard/lib/themeroller.js"></script>

    <script type="text/javascript">
      // This is the code for definining the dashboard
      $(document).ready(function() {

        // load the templates
        $('body').append('<div id="templates"></div>');
        $("#templates").hide();
        $("#templates").load("layouts/user_dash_placeholder.html", initDashboard);

        // call for the themeswitcher
        $('#switcher').themeswitcher();

        // call for the minimal dashboard
        function initDashboard() {
          var dashboard = $('#dashboard').dashboard({
            json_data : { url: "widgets/jsonfeed/defaultwidgets.json" }
          });
          dashboard.init();
        }
      });

    </script>

    <link rel="stylesheet" type="text/css" href="css/dashboardui.css" />
    <link rel="stylesheet" type="text/css" href="libraries/dashboard/themes/default/jquery-ui-1.8.2.custom.css" />

  </head>

  <body>
	
  <div class="header_tile_image">
  	
    <div class="headerbox">
     <div id="switcher"></div>
       <h1>User Dashboard </h1>
       <h4>Logged in as <?php echo $_SESSION['email']; ?></h4>
    </div>
   
  </div>
  <div id="nav_panel"> 
  <h5><p><a href="/scripts/authentication/logout.php">LOGOUT</a></p></h5>
  </div>
  </div>


  <div id="dashboard" class="dashboard">
    <div class="layout">
      <div class="column first column-first"></div>
      <div class="column second column-second"></div>

    </div>
  </div>

  </body>
</html>
