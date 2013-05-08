<?php
	include("../php/Producto.class.php");
	$idP = $_GET["id"];
	$result = Producto::Eliminar($idP);
	
	if($result){
		echo "OK";
	}else{
		echo "ERROR";
	}

?>