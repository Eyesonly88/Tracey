<?php

# File to store dynamic functions for prepared statement creation (perhaps)

/* Dynamic function that binds a dynamic number of result parameters and returns the result array */
function dynamicBindResults($stmt) {
	
	$parameters = array();  
   	$results = array();  
  
   	$stmt->execute();  
  
   	$meta = $stmt->result_metadata();  
  
   	while ( $field = $meta->fetch_field() ) {  
    	$parameters[] = &$row[$field->name];  
   	}  
  
   	call_user_func_array(array($stmt, 'bind_result'), $parameters);  
  
   	while ( $stmt->fetch() ) {  
   	   $x = array();  
    	  foreach( $row as $key => $val ) {  
     	    $x[$key] = $val;  
			
    	  }  
   	   $results[] = $x;  
   	}  
  
  	 return $results; 
}


?>