<?php
	include("../php/Proveedor.class.php");
	$rfc = $_GET["id"];
	$result = Proveedor::Desbloquear($rfc);
	if ( $result ){
		echo "OK";
	} else {
		echo "ERROR";
	}
?>