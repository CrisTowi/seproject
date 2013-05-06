<?php
	include("../php/DataConnection.class.php");		
	$db = new DataConnection();
	
	$sql = "SELECT * 
			FROM producto
			WHERE Nombre LIKE '%" . mysql_real_escape_string($_GET['term']) . "%'";
	
	$result = $db->executeQuery($sql);
	
	$return_arr = array();
	    
    while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
		$row_array['idProductoElegido'] = $row['idProducto'];
		$row_array['value'] = utf8_encode($row['Nombre']);			
	
        array_push($return_arr, $row_array);
    }
	
	/* Toss back results as json encoded array. */
	echo json_encode($return_arr);
?>