<?php
	include("../php/DataConnection.class.php");
	include("../php/Validations.class.php");
	$db = new DataConnection();
	$result = $db->executeQuery("SELECT * FROM Proveedor where status = 0");
	$name = "proveedor";
	if ( isset($_GET["name"]) ){
		$name = Validations::cleanString($_GET["name"]);
	}
	echo "<select id='".$name."' name='".$name."' onChange='loadTable();'>";
	echo "<option value='-1'>Elige Proveedor</option>";
				
	while( $dato = mysql_fetch_assoc($result) ){
		echo "<option value='".$dato["RFC"]."'>".$dato["Nombre"]."</option>";
	}
	echo "</select>";
?>