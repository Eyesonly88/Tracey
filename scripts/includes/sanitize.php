<?php


$search = array(
    '@<script[^>]*?>.*?</script>@si',   // Strip out javascript
    '@<[\/\!]*?[^<>]*?>@si',            // Strip out HTML tags
    '@<style[^>]*?>.*?</style>@siU',    // Strip style tags properly
    '@<![\s\S]*?--[ \t\n\r]*>@',         // Strip multi-line comments
	'/^[A-Za-z0-9_- ]+$/'
);


function sanitizeCheck($input) {
	
	$invalid = 0;
	if (preg_match($search, $input) { 	
		$invalid = 1;	
		PRINT "Malicious code found";
	}
	return $invalid;

} 

function sanitize($input) { 

	$output = '';
	if (preg_match($search, '', $input) { 	
		$output = preg_replace($search, '', $input);
		PRINT 'Input sanitized';	
	}
	return $output;
}  
   

?>