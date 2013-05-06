<?php 
	/*
		AgregaComp.php
		
		Agrega
		Regresa:
			OK	: La transacción se realizo correctamente
			DATABASE_PROBLEM: No se pudo realizar la acción en la bd
			MISSMATCH_PASSWORD: Los passwords no coinciden
			INPUT_PROBLEM: Algun elemento no tiene el formato correcto
	*/
	include("../php/Validations.class.php");
	include("../php/Compras.class.php");	
	$numero    =	$_GET['numprod'];
	$proveedor    =	$_GET['proveedor'];
	
			for($i = 1; $i<= $numero; $i++){
				$productos[$i] = $_GET['producto'.$i];	
			}
		$total      =	$_GET['total'];
			$accept   =	Compras::Agregar($productos,$total,$proveedor);	
			
			if(!$accept){
				echo "DATABASE_PROBLEM";
			}else{
				echo "OK";
			}
		
	

?>