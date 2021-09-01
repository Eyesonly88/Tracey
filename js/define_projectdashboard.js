 $(document).ready(function() { 
 	
 	$.ajax({
  	   cache: "false",
	   type: "POST",
	   url: "/scripts/project/checkProjectPermissions.php",
	   data: 'projectid='+$('#pid').val()+'&userid='+$('#user').val(),
	   success: function(msg){
	   	//alert('projectid='+$('#pid').val()+'&userid='+$('#user').val() + '   ' + msg);
	     if (msg != 1){ 
	     	window.location.replace('/index.php');
	     }
	   }
   
 	});
 	
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
          	
            json_data : { url: "/widgets/jsonfeed/projectdashboard_json/projectdashboard_defaultwidgets.json" },
            
            addWidgetSettings: {
              widgetDirectoryUrl:"/widgets/jsonfeed/projectdashboard_json/projectdashboard_widgetcategories.json"
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