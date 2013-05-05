<?php 
	include("../Validations.class.php");
	include("../DataConnection.class.php");
	$id = Validations::cleanString($_GET["id"]);	
	$db = new DataConnection();
	if ( isset($_GET["reverse"]) ){
		$qry = "UPDATE mensajes SET archivado=0 WHERE id=".$id;
	}else{
		$qry = "UPDATE mensajes SET archivado=1 WHERE id=".$id;
	}
	$result = $db->executeQuery($qry);	
	if ( $result == true )
		echo "OK";
	else
		echo "ERROR";
?>