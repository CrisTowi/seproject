<?php
	include("../php/Compras.class.php");
	$idCompra = $_GET["id"];
	$result = Compras::Finalizar($idCompra);
	if ( $result ){
		echo "OK";
	} else {
		echo "ERROR";
	}
?>