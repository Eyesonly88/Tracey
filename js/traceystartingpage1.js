

function initMenu() {
var hidden1 = 0;
	$('#menu').hide();
  $('#menu ul').hide();
  $('#menu ul:first').hide();
  
  $('h1').click( function() { 
	
	if (hidden1 == 0) {
		$('#menu').slideDown('normal'); 
		$("h1").css("background-color","#121312"); 
		$("div#instruction1").hide();
		//$("h1").css("color","#dddddd");
		//$("h1:hover").css("color","#000000");
		hidden1 = 1;
	} else {
		$('#menu').slideUp('normal'); 
		$("h1").css("background-color","#111111"); 
		$("div#instruction1").show();
		//$("h1").css("color","#121312");
		//$("h1:hover").css("color","#dddddd");
		hidden1 = 0;
	}
  
  } );
  
  $('#menu li a').click(
    function() {
      var checkElement = $(this).next();
      if((checkElement.is('ul')) && (checkElement.is(':visible'))) {
		checkElement.slideUp('normal');
        return false;
        }
      if((checkElement.is('ul')) && (!checkElement.is(':visible'))) {
        $('#menu ul:visible').slideUp('normal');
        checkElement.slideDown('normal');
        return false;
        }
      }
    );
  }
$(document).ready(function() {initMenu();});