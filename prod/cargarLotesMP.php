<?php
	include("../php/DataConnection.class.php");		
	$db = new DataConnection();
	
	////Devolver resultado en echo
	$idMP = $_POST['valor'];
	$numIng = $_POST['contador'];
	
	$query = "select * from mp_almacen
			  where idMateriaPrima=$idMP;";	

	$result = $db->executeQuery($query);	
	
	if (!$result) 
		die ("Database access failed: " . mysql_error());
		
	$rows = mysql_num_rows($result);
	
	if($rows>0)
	{
		echo '<select id="lotesIng'.$numIng.'" class="loteMP">';	
		for ($j = 0 ; $j < $rows ; ++$j)
		{
			$row = mysql_fetch_row($result);		
			echo '<option value="'.$row[0].'">' . $row[0] . '</option>';				
		}
		echo '</select>';
		//echo '<input type="hidden" id="cant'. $j.'" value="'. $row[3].'"/>';
	}else
		echo '<p style="width: 150px; color: rgb(176,0,0); font-weight: bold; ">Sin lotes disponibles</p>';
	
?> 