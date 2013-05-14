<?php 
	/*
		agregaProveedorBD.php
		
		Agrega o modifica un empleado en la base de datos
		
		Recibe:
			$_GET["rfc"]: Nombre del empleado
			$_GET["nombre"]  : CURP del empleado
			$_GET["direccion"]  : Contraseña del empleado
			$_GET["telefono"] : Confirmación de la contraseña del empleado
			$_GET["email"]   : Dirección del empleado
			$_GET["edit"]  : 1 cuando ya existe el proveedor (modificar),
							 sin definir cuando se agrega el empleado
		
		Regresa:
			OK	: La transacción se realizo correctamente
			DATABASE_PROBLEM: No se pudo realizar la acción en la bd
			INPUT_PROBLEM: Algun elemento no tiene el formato correcto
	*/
	include("../php/Validations.class.php");
	include("../php/Proveedor.class.php");
	$rfc       =	Validations::cleanString($_GET['rfc']);
	$nombre    =	Validations::cleanString($_GET['nombre']);
	$direccion =	Validations::cleanString($_GET['direccion']);
	$telefono  = 	Validations::cleanString($_GET['telefono']);
	$email     = 	Validations::cleanString($_GET['email']);
	$numero    =	Validations::cleanString($_GET['numprod']);
	$flag = false;
	
	
	for($i = 1; $i<= $numero; $i++){
		$productos[$i] = $_GET['producto'.$i];
		$precios[$i] = $_GET['precio'.$i];
		if(!(Validations::validaFloat($precios[$i])))
		{
			$flag = true;
			break;
		}
	}
	
	/* Decodifica los caracteres de la URL */
	$direccion = str_replace("%23", "#", $direccion);
	
	
	if(!(Validations::validaRFC($rfc)))
		echo "RFC_PROBLEM";
	else if(!(Validations::validaNombre($nombre)))
		echo "NAME_PROBLEM";
	else if(!(Validations::validaTel($telefono)))
		echo "TEL_PROBLEM";
	else if(!(Validations::validaEmail($email)))
		echo "EMAIL_PROBLEM";
	else if($numero == 0)
		echo "PRODUCT_PROBLEM";
	else if($flag)
		echo "PRICE_PROBLEM";
	else
	{
		if ( Proveedor::findById($rfc) != false && !isset($_GET["edit"]) ){
			echo "ID_ALREADY_USED";
		}
		else
		{		
			if ( !isset($_GET["edit"]) )
			{
				$accept = Proveedor::Agregar($rfc, $nombre, $direccion, $telefono, $email, $productos, $precios);
			}
			else
			{
				$accept = Proveedor::Modificar($rfc, $nombre, $direccion, $telefono, $email, $productos, $precios);
			}
			if(!$accept)
			{
				echo "DATABASE_PROBLEM";
			}
			else
			{
				echo "OK";
			}
		}
	}
?>