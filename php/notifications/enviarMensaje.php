<?php
	include("../AccessControl.php");
	include("../Validations.class.php");
	include("../DataConnection.class.php");	
	$asunto = Validations::cleanString($_GET["asunto"]);	
	$area = Validations::cleanString($_GET["area"]);	
	$mensaje = Validations::cleanString($_GET["mensaje"]);	
	$problema = Validations::cleanString($_GET["problema"]);		
	if ( $problema == "true" )
		$problema = 1;
	else
		$problema = 0;	
	$db = new DataConnection();		
	$qry = "INSERT INTO Mensajes VALUES ( null , '".$sesion->getEmpleado()->getCurp()."','".$mensaje."',curdate(),'".$asunto."',".$area.",".$problema.",0,0);";	
	$result = $db->executeQuery($qry);		
	if ( $result == true )
		echo "OK";
	else
		echo "ERROR";
?>