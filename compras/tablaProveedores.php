<?php
	/*
		tablaProveedores.php
		Última modificación: 17/04/2013		
		
		Genera la tabla de proveedores dinamicamente.
		
		Recibe:
			$_GET["search"] : filtro de la búsqueda de proveedores en RFC o Nombre
			
		- Documentación del código: OK		
	*/
	header('Cache-Control: no-cache, no-store, must-revalidate');
?>
<table id="table-content">
	<tr class="tr-header">
		<td>RFC</td>
		<td>Nombre</td>
		<td>Tel&eacute;fono</td>
        <td>Email</td>
		<td>Status</td>
	</tr>
<?php
	include("../php/DataConnection.class.php");
	include("../php/Validations.class.php");
	$db = new DataConnection();	
	$qry = "SELECT * FROM Proveedor WHERE Status != 2";
	
	// Añade parametros de búsqueda
	if ( isset($_GET["search"] ) ){ 
		$filtro = Validations::cleanString($_GET["search"]); // Limpia la entrada
		$qry .= " AND (RFC LIKE '%".$filtro."%' OR Nombre LIKE '%".$filtro."%')";
	}
	
	$result = $db->executeQuery($qry);
	
	if ( mysql_num_rows($result) < 1){
		echo ("<tr class='tr-cont'>
			<td colspan='5'>No se encontraron resultados</td>
			<td class='opc'></td>
			<td class='opc'></td>
			<td class='opc'></td>
		</tr>");
	}else{
		/* Agrega los resultados */
		while($fila = mysql_fetch_array($result))
		{		
			$id = $fila['RFC'];	
			$nombre = $fila['Nombre'];
			$direccion = $fila['Direccion'];
			$telefono = $fila['Telefono'];
			$email = $fila['Email'];
			$status = $fila['Status'];
			if($status == 0)
				$status = 'Activo';
			else
				$status = 'Bloqueado';
			$noReportes = $fila['No_reportes'];
			
			echo ("<tr class='tr-cont' id='".$id."' name='".$id."'>
				<td>".$id."</td>
				<td>".$nombre."</td>
				<td>".$telefono."</td>
				<td>".$email."</td>
				<td>".$status."</td>
				<td class='opc'><img src='../img/pencil.png' onclick='modificarProveedor(\"".$id."\")' alt='Modificar' class='clickable'/></td>
				<td class='opc'><img src='../img/less.png'   onclick='eliminarProveedor(\"".$id."\")' alt='Eliminar' class='clickable'/></td>
				");
				//Si esta status mostramos el boton para desbloquear sino no.
				if($fila['Status'] == 1)
				{
					echo ("<td class='opc'><img src='../img/desbloquear.png'  onclick='desbloquearProveedor(\"".$id."\")' alt='Desbloquear' class='clickable'/></td>");
				}
			echo ("</tr>");
		}
	}
?>
</table>