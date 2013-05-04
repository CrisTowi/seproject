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

	/* Decodifica los caracteres de la URL */
	$direccion = str_replace("%23", "#", $direccion);
	
	if ( Validations::validaNombre($nombre))// && Validations::validaRFC($rfc) )
	{
		if ( !isset($_GET["edit"]) )
		{
			$accept = Proveedor::Agregar($rfc, $nombre, $direccion, $telefono, $email);
		}
		else
		{
			$accept = Proveedor::Modificar($rfc, $nombre, $direccion, $telefono, $email);
		}
		if(!$accept)
		{
			echo "DATABASE_PROBLEM";
		}
		else
		{
			echo "OK";
		}
	}else{
		echo "INPUT_PROBLEM";
	}

?>