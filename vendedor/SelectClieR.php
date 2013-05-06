<?php
	include("../php/DataConnection.class.php");
	$db = new DataConnection();
	$result = $db->executeQuery("SELECT RFC,Nombre FROM cliente where Estado is null");
	$name = "cliente";
	$todos = "Todos";
	if ( isset($_GET["name"]) ){
		$name = Validations::cleanString($_GET["name"]);
	}
	
	echo "<select id='clie' name='".$name."'>";
	echo "<option value='0'>"."Todos"."</option>";
	while( $dato = mysql_fetch_assoc($result) ){
		echo "<option value='".$dato["RFC"]."'>".$dato["Nombre"]."</option>";
	}
	echo "</select>";
	
?>
