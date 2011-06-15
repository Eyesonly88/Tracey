<?php

/* 
Sanitize.php Script
Description: Functions to sanitize user inputs.
*/

$search = array(
    '@<script[^>]*?>.*?</script>@si',   // Strip out javascript
    '@<[\/\!]*?[^<>]*?>@si',            // Strip out HTML tags
    '@<style[^>]*?>.*?</style>@siU',    // Strip style tags properly
    '@<![\s\S]*?--[ \t\n\r]*>@',         // Strip multi-line comments
	'/^[A-Za-z0-9_- ]+$/'				// non-alphanumeric
);

/* Check for malicious code. Return 1 if one found. */
function sanitizeCheck($input) {
	
	$invalid = 0;
	if (preg_match($search, $input) { 	
		$invalid = 1;	
		echo "Malicious code found";
	}
	return $invalid;

} 

/* Replace malicious code with '' */
function sanitize($input) { 

	$output = $input;
	if (preg_match($search, '', $input) { 	
		$output = preg_replace($search, '', $input);
		echo 'Input sanitized';	
	}
	return $output;
}  
   

?>