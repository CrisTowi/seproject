<?php
	include("../php/Validations.class.php");
	include("../php/Producto.class.php");

	$nombre = Validations::cleanString($_GET['nombre']);
	$precio = Validations::cleanString($_GET['precio']);
	$presentacion = Validations::cleanString($_GET['presentacion']);
	$lote = Validations::cleanString($_GET['lote']);
	$idProd = Validations::cleanString($_GET['idp']);

	/* Decodifica los caracteres de la URL*/
	$direccion = str_replace("%23","#",$direccion);

	if(!isset($_GET["edit"])){
		$accept = Producto::Agregar($nombre,$lote,$presentacion,$precio);
	}else{
		$accept = Producto::Modificar($nombre,$lote,$presentacion,$precio,$idProd);
	}

	if(!$accept){
		echo "DATABASE_PROBLEM";
	}else{
		echo "OK";
	}

?>