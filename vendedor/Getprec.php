<?php
	include("../php/DataConnection.class.php");
	//include("../php/Validations.class.php");
	$db = new DataConnection();
	$result = $db->executeQuery("SELECT Precio FROM producto where idProducto=".$_GET['id']);
	$dato = mysql_fetch_assoc($result);
	echo "<input type='text' id='precio' size='5' maxlength='7' value='$".$dato["Precio"]."' disabled/>"
?>

