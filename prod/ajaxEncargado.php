<?php
	include("../php/DataConnection.class.php");		
	$db = new DataConnection();
	
	$return_arr = array();
 	
	$sql = "SELECT * 
			FROM empleado 
			WHERE Area = 6 and Nombre LIKE '%" . mysql_real_escape_string($_GET['term']) . "%';";

	$result = $db->executeQuery($sql);	
     
    /* Retrieve and store in array the results of the query.*/
    while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
		$row_array['curpEmpleado'] = $row['CURP'];
		$row_array['value'] = $row['Nombre'];					
			
        array_push($return_arr, $row_array);
    }	 	
 
	/* Toss back results as json encoded array. */
	echo json_encode($return_arr);
?>