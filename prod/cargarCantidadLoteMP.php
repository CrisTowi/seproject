<?php
	include("../php/DataConnection.class.php");		
	$db = new DataConnection();
	
	$noLote = $_POST['valor'];			
	
	$query = "select a.cantidad, m.unidad
			  from inventario_mp a, materiaprima m
			  where a.idMateriaPrima = m.idMateriaPrima
			  and idLote='$noLote'";
	 	
	$result = $db->executeQuery($query);	

	if (!$result) 
		die ("Database access failed: " . mysql_error());
		
	$rows = mysql_num_rows($result);
	
	for ($j = 0 ; $j < $rows ; ++$j)
	{
		$row = mysql_fetch_row($result);		
		echo '<p style="text-align: center;">'.$row[0].' '.$row[1].'</p>';
	}
	
	
?> 