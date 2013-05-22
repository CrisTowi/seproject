<!DOCTYPE html>
<html>
    <head>
		<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
        <title>Modificar Lote</title>
	</head>
<?php

	include("../php/DataConnection.class.php");		
	$db = new DataConnection();		
	
	////Devolver resultado en echo
	$idLote = $_POST['noLote'];
	$nuevoNoLinea = $_POST['lineaProduccion'];
	$idProducto = $_POST['idProducto'];
	$nuevaCantidad = $_POST['cantidad'];
	$nuevoCurpEncargado = $_POST['curpEmpleado'];
	$nuevaFechaElaboracion = $_POST['fechaElab'];
	$nuevaFechaCaducidad = $_POST['fechaCad'];
	$totalIngredientes = $_POST['totalIngredientes'];		
		
	$query = "SELECT COUNT(*) 
			FROM lote 
			WHERE noLinea = $nuevoNoLinea and fecha_elaboracion = '$nuevaFechaElaboracion'";	
	$result = $db->executeQuery($query);	
	if (!$result) 
		die ("Database access failed: " . mysql_error());
	$row = mysql_fetch_row($result);
	$bandera = $row[0];
	
	$query = "SELECT noLinea, fecha_elaboracion
			FROM lote 
			WHERE idLote = '$idLote'";	
	$result = $db->executeQuery($query);	
	if (!$result) 
		die ("Database access failed: " . mysql_error());
	$row = mysql_fetch_row($result);
	
	if($nuevaFechaElaboracion==$row[1] && $nuevoNoLinea==$row[0])
		$bandera=0;
	
	if($bandera > 0){
		echo '<script>
				alert("No fue posible modificar el lote. La línea de producción '.$nuevoNoLinea.' ya tiene un lote registrado en la fecha '.$nuevaFechaElaboracion.'.");
				window.history.back();
		 	</script>';
	}
	else{		
	
		$query = "update lote set fecha_elaboracion='$nuevaFechaElaboracion', fecha_caducidad='$nuevaFechaCaducidad',
				  cantidadProducto=$nuevaCantidad, noLinea=$nuevoNoLinea, curpEmpleado='$nuevoCurpEncargado' where idLote='$idLote'";	
		$result = $db->executeQuery($query);	
		if (!$result) 
			die ("Database access failed: " . mysql_error());
		
		//Primero va el ciclo de devoluciones
		$query = "select * from uso_mp where idLoteProduccion='$idLote'";
		$resultOtro = $db->executeQuery($query);	
		if (!$resultOtro) 
			die ("Database access failed: " . mysql_error());
				
		for( $i=0; $i<$totalIngredientes; $i++){
									
			$row = mysql_fetch_row($resultOtro);
				
			$query = "update inventario_mp set cantidad=cantidad+".$row[2]." where idLote='".$row[1]."'";	
			$result = $db->executeQuery($query);	
			if (!$result) 
				die ("Database access failed: " . mysql_error());
		}
		
		//Query para eliminar informacion de uso_mp
		$query = "delete from uso_mp where idLoteProduccion='$idLote'";	
		$result = $db->executeQuery($query);	
		if (!$result) 
				die ("Database access failed: " . mysql_error());
		
		//Ciclo para agregar los nuevos lotes de MP que conformarán al lote de producto
		for( $i=0; $i<$totalIngredientes; $i++){
			$loteMP = $_POST['lotesIng'.$i];
			$cantidadMP = $_POST['cantReqFinal'.$i];
			
			$query = "insert into uso_mp values( '$idLote', '$loteMP', $cantidadMP)";	
			$result = $db->executeQuery($query);	
			if (!$result) 
				die ("Database access failed: " . mysql_error());
				
			$query = "update inventario_mp set cantidad=cantidad-$cantidadMP where idLote='$loteMP'";	
			$result = $db->executeQuery($query);	
			if (!$result) 
				die ("Database access failed: " . mysql_error());
		}
		
		echo '<script>
			alert("El Lote ha sido modificado exitosamente.");
			window.location="GestionarLotes.php";
		 </script>';
	}
	
?> 

</html>