<!DOCTYPE html>
<html>
    <head>
		<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
        <title>Registrar Lote</title>
	</head>
<?php

	include("../php/DataConnection.class.php");		
	$db = new DataConnection();		
	
	////Devolver resultado en echo
	$noLinea = $_POST['lineaProduccion'];
	$idProducto = $_POST['idProducto'];
	$cantidad = $_POST['cantidad'];
	$curpEncargado = $_POST['curpEmpleado'];
	$fechaElaboracion = $_POST['fechaElab'];
	$fechaCaducidad = $_POST['fechaCad'];
	$totalIngredientes = $_POST['totalIngredientes'];
	
	$query = "SELECT COUNT(*) 
			FROM lote 
			WHERE noLinea = $noLinea and fecha_elaboracion = '$fechaElaboracion'";	
	$result = $db->executeQuery($query);	
	if (!$result) 
		die ("Database access failed: " . mysql_error());
	$row = mysql_fetch_row($result);
	$bandera = $row[0];
	
	if($bandera > 0){
		echo '<script>
				alert("La línea de producción '.$noLinea.' ya tiene un lote registrado en la fecha seleccionada.");
				window.history.back();
		 	</script>';
	}
	else{
		$query = "SELECT clave 
					FROM producto 
					WHERE idProducto = $idProducto";	
		$result = $db->executeQuery($query);			
		if (!$result) 
			die ("Database access failed: " . mysql_error());
		
		$row = mysql_fetch_row($result);
		$claveLote = $row[0];	
	
		$query = "SELECT COUNT(*)+1 FROM lote;";	
		$result = $db->executeQuery($query);	
		if (!$result) 
			die ("Database access failed: " . mysql_error());
		$row = mysql_fetch_row($result);
		$num = $row[0];
	
		$noLote = $claveLote.$num;	//Se une la clave del producto con el valor numérico
	
		$query = "INSERT INTO lote VALUES( '$noLote', $idProducto, '$fechaElaboracion', '$fechaCaducidad', NULL, $cantidad, $noLinea, '$curpEncargado')";	
		$result = $db->executeQuery($query);	
		if (!$result) 
			die ("Database access failed: " . mysql_error());
		
		for( $i=0; $i<$totalIngredientes; $i++){
			$loteMP = $_POST['lotesIng'.$i];
			$cantidadMP = $_POST['cantReqFinal'.$i];
			
			$query = "insert into uso_mp values( '$noLote', '$loteMP', $cantidadMP)";	
			$result = $db->executeQuery($query);	
			if (!$result) 
				die ("Database access failed: " . mysql_error());
				
			$query = "update inventario_mp set cantidad=cantidad-$cantidadMP where idLote='$loteMP'";	
			$result = $db->executeQuery($query);	
			if (!$result) 
				die ("Database access failed: " . mysql_error());
		}
		
		echo '<script>
			alert("El Lote ha sido registrado exitosamente.");
			window.history.back();
		 </script>';
	}
	
?> 

</html>