<?php
	include("../php/DataConnection.class.php");
	include("../php/Validations.class.php");
	$db = new DataConnection();
	$result = $db->executeQuery("SELECT cantidadProducto FROM lote where Estado is NULL and idlote='".$_GET['id']."'");
	$dato = mysql_fetch_assoc($result);
	echo "<input type='text' id='cantidadp' style='visibility:hidden' value='".$dato["cantidadProducto"]."' />"
	//echo "</select>";
?>

