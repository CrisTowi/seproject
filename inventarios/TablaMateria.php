<table id='table-content'>
	<tr class='tr-header'  style='color: white'>
		<td>id Producto</td>
		<td>Nombre</td>
		<td>Proveedor</td>
		<td>Precio por unidad ($)</td>
		<td>Cantidad</td>
		<td>Unidad</td>
		<td>Fecha de Caducidad</td>
		<td class='opc'> </td>
		<td class='opc'> </td>
	</tr>

<?php
	include("../php/DataConnection.class.php");
	include("../php/Validations.class.php");

	$db = new DataConnection();	
	$qry = "SELECT mp.idMateriaPrima, mp.nombre, 
			p.nombre as proveedor, s.precioactual, s.cantidad,
			mp.unidad, s.fecha_caducidad, s.idSuministro
			from materiaprima mp, proveedor p, 
			suministro s
			where mp.idMateriaPrima = s.idMateriaPrima
			and p.RFC = s.RFC";	

	// Añade parametros de búsqueda
	if (isset($_GET["search"]) ){
		$filtro = Validations::cleanString($_GET["search"]);
		if($filtro != "")
		{
			if(is_numeric($filtro))
			{
				$qry .= " AND mp.idMateriaPrima = ".$filtro;
			}
			else
			{
				$qry .= " AND (mp.nombre LIKE '%".$filtro."%' OR p.nombre LIKE '%".$filtro."%')";
			}
		}
	}

	$result = $db->executeQuery($qry);	

	if ( mysql_num_rows($result) < 1){
		echo ("<tr class='tr-cont'>
			<td colspan='7'>No se encontraron resultados</td>
			<td class='opc'></td>
			<td class='opc'></td>
		</tr>");
	}else{		
	
		while($fila = mysql_fetch_array($result))
		{		
			$ids = $fila['idSuministro'];	
			$idm = $fila['idMateriaPrima'];	
			$nombre = $fila['nombre'];
			$proveedor = $fila['proveedor'];
			$precio = $fila['precioactual'];
			$cantidad = $fila['cantidad'];
			$unidad = $fila['unidad'];
			$fecha_C = $fila['fecha_caducidad'];

			echo "<tr class='tr-cont' id='".$idm."' name='".$idm."'>
				<td>".$idm."</td>
				<td>".$nombre."</td>
				<td>".$proveedor."</td>
				<td>".$precio."</td>
				<td>".$cantidad."</td>
				<td>".$unidad."</td>
				<td>".$fecha_C."</td>
				<td class='opc'><img src='../img/less.png'   onclick='eliminarEmpleado(\"".$ids."\")' alt='Eliminar' class='clickable'/></td>
			</tr>";
		}
	}
?>

</table>