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
				alert("No fue posible registrar el lote. La l�nea de producci�n '.$noLinea.' ya tiene un lote registrado en la fecha '.$fechaElaboracion.'.");
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
		$claveProducto = $row[0];	
	
	////Mejor forma de generar N�meros de lote
	/*
		$partesFecha = explode ("-", $fechaElaboracion);	
		$dia = $partesFecha[2];
		$mes = $partesFecha[1];  
		$anyoCompleto = $partesFecha[0];		
		$partesAnyo = explode ("0", $anyoCompleto);
		$anyo = $partesAnyo[1];			
		$noLote = $claveProducto.$noLinea.$anyo.$mes.$dia;	//Se une la clave del producto, mas la linea de produccion y la fecha de elaboracion.
															//para generar numeros de lote irrepetibles
	*/
		$query = "SELECT COUNT(*)+1 FROM lote;";	
		$result = $db->executeQuery($query);	
		if (!$result) 
			die ("Database access failed: " . mysql_error());
		$row = mysql_fetch_row($result);
		$num = $row[0];
	
		$noLote = $claveProducto.$num;	//Se une la clave del producto con el valor num�rico
	
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
			window.location="GestionarLotes.php";
		 </script>';
	}
	
?> 

</html>