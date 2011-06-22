<?php

/* 
Sanitize.php Script
Description: Functions to sanitize user inputs.
*/

$search = array(
    '@<script[^>]*?>.*?</script>@si',   // Strip out javascript
    '@<[\/\!]*?[^<>]*?>@si',            // Strip out HTML tags
    '@<style[^>]*?>.*?</style>@siU',    // Strip style tags properly
    '@<![\s\S]*?--[ \t\n\r]*>@'         // Strip multi-line comments
);

/* Check for malicious code. Return 1 if one found. */
function sanitizeCheck($input) {
	global $search;
	$invalid = 0;
	if (preg_match($search, $input)){ 	
		$invalid = 1;	
		echo "Malicious code found";
	}
	return $invalid;
} 

/* Replace malicious code with '' */
function sanitize($input) { 
	global $search;
	#print_r($search);
	$output = $input;

	foreach($search as $regex) {
		if (preg_match($regex, $output)){ 	
			$output = "";
			echo 'Input sanitized <BR />';	
			return $output;
		}
	}
	return $output;
}  
   

?>