
<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sessions.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sql_notificationfn.php');

confirmLogin();

?>

<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <title>User Dashboard</title>

    <script type="text/javascript" src="libraries/dashboard/lib/jquery-1.4.2.min.js"></script>
    <script type="text/javascript" src="libraries/dashboard/lib/jquery-ui-1.8.2.custom.min.js"></script>
    <script type="text/javascript" src="libraries/dashboard/jquery.dashboard.js"></script>
    <script type="text/javascript" src="libraries/dashboard/lib/themeroller.js"></script>
	<script src="js/jquery.hoverIntent.js"></script>
	<script src="js/loginpanel.js"></script>
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
          var startId = 100;
          var dashboard = $('#dashboard').dashboard({
          	
          	layoutClass:'layout',
          	
            json_data : { url: "/widgets/jsonfeed/defaultwidgets.json" },
            
            addWidgetSettings: {
              widgetDirectoryUrl:"/widgets/jsonfeed/widgetcategories.json"
            },

            // Definition of the layout
            // When using the layoutClass, it is possible to change layout using only another class. In this case
            // you don't need the html property in the layout

            layouts :
              [
                { title: "Layout1",
                  id: "layout1",
                  image: "/layouts/layout1.png",
                  html: '<div class="layout layout-a"><div class="column first column-first"></div></div>',
                  classname: 'layout-a'
                },
                { title: "Layout2",
                  id: "layout2",
                  image: "/layouts/layout2.png",
                  html: '<div class="layout layout-aa"><div class="column first column-first"></div><div class="column second column-second"></div></div>',
                  classname: 'layout-aa'
                },
                { title: "Layout3",
                  id: "layout3",
                  image: "/layouts/layout3.png",
                  html: '<div class="layout layout-ba"><div class="column first column-first"></div><div class="column second column-second"></div></div>',
                  classname: 'layout-ba'
                },
                { title: "Layout4",
                  id: "layout4",
                  image: "/layouts/layout4.png",
                  html: '<div class="layout layout-ab"><div class="column first column-first"></div><div class="column second column-second"></div></div>',
                  classname: 'layout-ab'
                },
                { title: "Layout5",
                  id: "layout5",
                  image: "/layouts/layout5.png",
                  html: '<div class="layout layout-aaa"><div class="column first column-first"></div><div class="column second column-second"></div><div class="column third column-third"></div></div>',
                  classname: 'layout-aaa'
                }
              ]   
            
          });
          
          // binding for a widgets is added to the dashboard
          dashboard.element.live('dashboardAddWidget',function(e, obj){
            var widget = obj.widget;

            dashboard.addWidget({
              "id":startId++,
              "title":widget.title,
              "url":widget.url,
              "metadata":widget.metadata
              }, dashboard.element.find('.column:first'));
          });
          dashboard.init();
        }
      });

    </script>
    <script>
    $(document).ready(function() {
    	$(".notifications-form").hide();
		$("#notifications").hoverIntent( 
			function(){
				$(".notifications-form").fadeIn(200);
			}
			,
			function(){
				$(".notifications-form").fadeOut(200);
			}
		)
		
		});
		
    </script>
	<link rel="stylesheet" type="text/css" href="css/customStyle.css" />
    <link rel="stylesheet" type="text/css" href="css/dashboardui.css" />
    <link rel="stylesheet" type="text/css" href="libraries/dashboard/themes/default/jquery-ui-1.8.2.custom.css" />

  </head>

  <body class="custom">
		<div id="header-area">
				<div id="header">
					<div class="menu-container">
						<!-- Menu items = Home, About, Help -->
						<ul class="menu">
							<li><a href="#">Home</a></li>
							<li><a href="#">About</a></li>
							<li><a href="#">Help</a></li>
						</ul>
					</div>
					
					<ul id="nav">
						<!-- Load Navigation items ..
							1. Logged in user = Account, Themes, Logout Button.
							2. Visitor = Login, Register.
						-->
						<li id="notifications">
							
							<div id="notification-icon">
								<h3>
								<?php
									// returns the number of notifications for the logged in user
									echo getNotifCountByEmail($_SESSION['email']);
								?>
								</h3>
							</div>
							
							<div id="notifications-container" class="notifications-form">
								<div id="notifications-content">
									<span style="color: #F1F4F7;">Join Project X by Magneto. ACCEPT or REJECT.</span>
									
								</div>
							</div>
						</li>
						<li id="login">
							<a href="#">
								<h3>Account Settings</h3>
								<span>Change account details or Logout</span>	
							</a>
							<div id='login-container' class='login-form'>
								<h1 class='login-title'></h1>
								<div class='login-top'></div>
								<div class='login-content'>
									<label>Logged in as <U><?php echo $_SESSION['email']; ?></U></label>
									<label><span><a href="/scripts/authentication/logout.php">LOGOUT</a></span></label>
								</div>
							</div>
						</li>
						<li id="register">
							<a href="#">
								<h3>Widgets and Layout</h3>
								<span>Add widgets or Edit Layout</span>	
							</a>
							<div class="register-form">
								<div id="switcher"></div>
								<a class="openaddwidgetdialog headerlink" href="#"><label>Add Widget</label></a>
      							<a class="editlayout headerlink" href="#"><label>Edit Layout</label></a>
							</div>
						</li>
					</ul>
				</div>
			
			
		</div>
  
  
	

  <div id="dashboard" class="dashboard">
    <div class="layout">
      <div class="column first column-first"></div>
      <div class="column second column-second"></div>
      <div class="column third column-third"></div>

    </div>
  </div>

  </body>
</html>
