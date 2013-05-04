<?php
	include("../php/Proveedor.class.php");
	$rfc = $_GET["id"];
	$result = Proveedor::Eliminar($rfc);
	if ( $result ){
		echo "OK";
	} else {
		echo "ERROR";
	}
?>