<?php
	include("../php/DataConnection.class.php");
	include("../php/Validations.class.php");
	$db = new DataConnection();
	$result = $db->executeQuery("SELECT idlote FROM lote where Estado is NULL and cantidadProducto > 0 and idProducto=".$_GET['id']." order by Fecha_Caducidad");
	$totalFilas    =    mysql_num_rows($result);
	echo "<option value=0>Pedido</option>";
	if($totalFilas>0){
	while( $dato = mysql_fetch_assoc($result) ){
	echo "<option value='".$dato["idlote"]."'>".$dato["idlote"]."</option>";}}
	
	//echo "</select>";
?>

