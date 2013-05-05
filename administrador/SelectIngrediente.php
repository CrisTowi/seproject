<?php
	include("../php/DataConnection.class.php");
	include("../php/Validations.class.php");
	$db = new DataConnection();
	$result = $db->executeQuery("SELECT * FROM materiaprima ORDER BY Nombre ASC");
	$name="SelIngrediente";
	echo "<select id='".$name."' name='".$name."'>";
	echo "<option value='nuevo'>Nuevo Ingrediente</option>";	
	while( $dato = mysql_fetch_assoc($result) ){
		echo "<option value='".$dato["idMateriaPrima"]."'>".$dato["Nombre"]."</option>";		
	}
	echo "</select>";
	
	$result = $db->executeQuery("SELECT * FROM materiaprima");
	while( $dato = mysql_fetch_assoc($result) ){
		echo "<input type='hidden' id='unidad".$dato["idMateriaPrima"]."' name'".$dato["idMateriaPrima"]."' value='".$dato["Unidad"]."'>";
	}
	
	
	
	
?>