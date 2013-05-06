<?php
	include("../php/DataConnection.class.php");
	include("../php/Validations.class.php");
	$db = new DataConnection();
	
	$qry = "SELECT idMateriaPrima, Nombre FROM materiaprima";
	
	$result = $db->executeQuery($qry);
	
	if(mysql_num_rows($result)>=1){
			while( $dato = mysql_fetch_assoc($result) ){
				echo "<option value='".$dato["idMateriaPrima"]."'>".$dato["Nombre"]."</option>";
			}
	} else{
					echo "<option value='-1'>No hay materia prima</option>";
			
	}
	
	
?>