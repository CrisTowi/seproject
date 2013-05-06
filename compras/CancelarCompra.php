<?php
	include("../php/Compras.class.php");
	$idCompra = $_GET["id"];
	$result = Compras::Cancelar($idCompra);
	if ( $result ){
		echo "OK";
	} else {
		echo "ERROR";
	}
?>