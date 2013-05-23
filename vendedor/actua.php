<?php
	include("../php/DataConnection.class.php");
	$db = new DataConnection();
	$result = $db->executeQuery("SELECT folio FROM venta WHERE Fentrega <=  curdate() and Estado  like '%En espera%'");
	
	while( $dato = mysql_fetch_assoc($result) ){
		$db->executeQuery("Update venta set Estado='Entregado' WHERE  folio=".$dato["folio"]);
		$db->executeQuery("Update articuloventa set Estado='Entregado' WHERE estado not like '%Cancelado%' and folio=".$dato["folio"]);
	}
?>
