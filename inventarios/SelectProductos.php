<?php
	include("../php/DataConnection.class.php");
	include("../php/Validations.class.php");
	$db = new DataConnection();
	
	$name = "producto";
	if ( isset($_GET["name"] ) ){
		if ( strlen($_GET["name"])>0){
			$filtro = Validations::cleanString($_GET["name"]); // Limpia la entrada
			$qry = "SELECT * FROM suministro where RFC = '".$filtro."'";
		}
	}else {
		$qry = "SELECT * FROM suministro where RFC = '1'";
	}
	
	$result = $db->executeQuery($qry);
	
	if(mysql_num_rows($result)>=1){
			echo "<option value='-1'>Elige Producto</option>";
			while( $dato = mysql_fetch_assoc($result) ){
				$qry2 = "select * from materiaprima where idMateriaPrima=".$dato["idMateriaPrima"]."";
				$result2 = $db->executeQuery($qry2);
					while( $dato2 = mysql_fetch_assoc($result2) ){
						echo "<option value='".$dato2["idMateriaPrima"]."'>".$dato2["Nombre"]."</option>";
					}
			}
		
	} else{
					echo "<option value='-1'>No existen productos</option>";
			
	}
	
	
?>