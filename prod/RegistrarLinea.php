<?php

	include("../php/Validations.class.php");
	include("clases/Produccion.class.php");	
	include("clases/ArticuloV.class.php");		
	
	if(isset($_GET['numprod'])){
		$numprod 	= Validations::cleanString($_GET['numprod']);		
		$estado 	= Validations::cleanString($_GET['estado']);
	}
	else{
		$numprod = 0;
	}
	
	if(isset($_GET['folio'])){
		$folio 		= Validations::cleanString($_GET['folio']);		
		$estado 	= Validations::cleanString($_GET['estado']);
	}
	else{
		$folio = 0;
	}	


	$linea 		= Validations::cleanString($_GET['linea']);
	$encargado 	= Validations::cleanString($_GET['encargado']);	
	$producto	= Validations::cleanString($_GET['producto']);	
	$cantidad	= Validations::cleanString($_GET['cantidad']);	
	$elaboracion = Validations::cleanString($_GET['elaboracion']);	
	$caducidad	= Validations::cleanString($_GET['caducidad']);	
/*
	echo $folio."<br />";
	echo $estado."<br />";
	echo "numProd: ".$numprod."<br />";
	echo $linea."<br />";
	echo $encargado."<br />";
	echo $producto."<br />";
	echo $cantidad."<br />";
	echo $elaboracion."<br />";				
	echo $caducidad;
*/

	//Si no se encuentra el campo edit se agrega, si no se modifica
	if(!isset($_GET["edit"])){
		//accept es igual al estado 
		$accept = Produccion::agregar($linea, $encargado, $producto, $cantidad, $elaboracion, $caducidad);
		//echo "ACCEPT: ".$accept."<br />";
	}
	else if(isset($_GET['folio'])){
		//echo "folio";
		$accept = ArticuloV::modificar($folio, $linea, $encargado, $producto, $cantidad, $elaboracion, $caducidad, $estado);
	}
	else{
		$accept = Produccion::modificar($numprod, $linea, $encargado, $estado, $producto, $cantidad, 
		$elaboracion, $caducidad);
		//echo "Accept: ".$accept;
	}

	//Resultado de la operacion
	if(!$accept){
		echo "DATABASE_PROBLEM";
	}
	else if($accept == "FECHA"){
		echo "DATE_PROBLEM";
	}
	else{
		echo "OK";
	}
?>