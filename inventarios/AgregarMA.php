<?php 

	include("../php/Validations.class.php");
	include("../php/Materia_Prima.class.php");
		
	$idm       =	Validations::cleanString($_GET['idm']);
	$idp       =	Validations::cleanString($_GET['idp']);
	$cantidad  = 	Validations::cleanString($_GET['cantidad']);
	$fecha_l   =	Validations::cleanString($_GET['fecha_l']);
	$fecha_c   =	Validations::cleanString($_GET['fecha_c']);

	$precio = 0;
	
	//echo  $idc.$nombre.$proveedor.$cantidad.$unidad.$precio.$fecha_c.$fecha_l;
	if (is_numeric($cantidad)){

		if ( !isset($_GET["edit"]) ){
			$accept     =	MateriaPrima::Agregar($idm,$idp,$cantidad,$precio,$fecha_c,$fecha_l);
		}else{
			$idc       =	Validations::cleanString($_GET['idc']);
			$accept     =	MateriaPrima::Modificar($idm,$idp,$cantidad,$precio,$fecha_c,$fecha_l,$idc);	
		}
		if(!$accept){
			echo "DATABASE_PROBLEM";
		}else{
			echo "OK";
		}
	}
	else{
		echo "INPUT_PROBLEM";
	}


?>