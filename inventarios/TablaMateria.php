<table id='table-content'>
	<tr class='tr-header'  style='color: white'>
		<td>id Lote</td>
		<td>id Materia Prima</td>
		<td>Nombre</td>
		<td>Proveedor</td>
		<td>Unidad</td>
		<td>Cantidad</td>
		<td>Fecha de Llegada</td>
		<td>Fecha de Caducidad</td>
		<td class='opc'> </td>
		<td class='opc'> </td>
	</tr>

<?php
	include("../php/DataConnection.class.php");
	include("../php/Validations.class.php");

	$db = new DataConnection();	
	$qry = "SELECT i.idLote,i.idMateriaPrima,m.nombre, p.nombre as proveedor, m.unidad ,i.cantidad, i.fecha_llegada, i.fecha_caducidad 
			FROM inventario_mp i,  proveedor p, materiaprima m
			WHERE i.idMateriaPrima = m.idMateriaPrima
			AND i.RFC = p.RFC ";	

	// Añade parametros de búsqueda
	if (isset($_GET["search"]) ){
		$filtro = Validations::cleanString($_GET["search"]);
		if($filtro != "")
		{
			if(is_numeric($filtro))
			{
				$qry .= " AND m.idMateriaPrima = ".$filtro." OR i.idLote = ".$filtro;
			}
			else
			{
				$qry .= " AND (m.nombre LIKE '%".$filtro."%' OR p.nombre LIKE '%".$filtro."%')";
			}
		}
	}

	$result = $db->executeQuery($qry);	

	if ( mysql_num_rows($result) < 1){
		echo ("<tr class='tr-cont'>
			<td colspan='8'>No se encontraron resultados</td>
			<td class='opc'></td>
			<td class='opc'></td>
		</tr>");
	}else{		
	
		while($fila = mysql_fetch_array($result))
		{		
			$idl = $fila['idLote'];	
			$idm = $fila['idMateriaPrima'];	
			$nombre = $fila['nombre'];
			$proveedor = $fila['proveedor'];
			$cantidad = $fila['cantidad'];
			$unidad = $fila['unidad'];
			$fecha_L = $fila['fecha_llegada'];
			$fecha_C = $fila['fecha_caducidad'];

			echo "<tr class='tr-cont' id='".$idm."' name='".$idm."'>
				<td>".$idl."</td>
				<td>".$idm."</td>
				<td>".utf8_encode($nombre)."</td>
				<td>".utf8_encode($proveedor)."</td>
				<td>".$unidad."</td>
				<td>".$cantidad."</td>
				<td>".$fecha_L."</td>
				<td>".$fecha_C."</td>
				<td class='opc'><img src='../img/less.png'   onclick='eliminarEmpleado(\"".$idl."\")' alt='Eliminar' class='clickable'/></td>
			</tr>";
		}
	}
?>

</table>