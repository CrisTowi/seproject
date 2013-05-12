﻿<table id='table-content'>
	<tr class='tr-header' style='color: white;'>
		<td>No Compra</td>
		<td>Fecha</td>
		<td>Productos</td>
		<td>Cantidad</td>
		<td>Total($)</td>
		<td class='opc'> </td>
	</tr>
<?php
	include("../php/DataConnection.class.php");
	include("../php/Validations.class.php");
	$db = new DataConnection();	
	$qry = "SELECT * FROM compra  WHERE status = 1";
	
	// Añade parametros de búsqueda
	if ( isset($_GET["search"] ) ){
		if ( strlen($_GET["search"])>0){
			$filtro = Validations::cleanString($_GET["search"]); // Limpia la entrada
			$qry .= " AND idCompra LIKE ".$filtro."";
		}
	}
	
	$result = $db->executeQuery($qry);	

	if ( mysql_num_rows($result) < 1){
		echo ("<tr class='tr-cont'>
			<td colspan='5'>No se encontraron resultados</td>
			<td class='opc'></td>
			</tr>");
	}else{	
		/* Agrega los resultados */
			
		while($fila = mysql_fetch_array($result))
		{	
			
			$id = $fila['idCompra'];	
			$Fecha = $fila['Fecha'];
			$qry2 = "Select mp.Nombre,cmp.Cantidad,mp.Unidad from Compra c join Compra_MP cmp ON c.idCompra = cmp.idCompra join MateriaPrima mp on mp.idMateriaPrima = cmp.idMateriaPrima where cmp.idCompra =".$id." ";
			$result2 = $db->executeQuery($qry2);	 
			$Productos="<ul>";
			$Cantidades="<ul>";
			while($filaNom=mysql_fetch_array($result2)){
						
					$Productos.="<li>".$filaNom['Nombre']."  (".$filaNom['Unidad'].") ". "</li>";
					$Cantidades.=$filaNom['Cantidad']."<br>";
			}
			$Productos.="</ul>";
			$Cantidades.="</ul>";
			$Total = $fila['Total'];
			
			echo ("<tr class='tr-cont' id='".$id."' name='".$id."'>
				<td>".$id."</td>
				<td>".$Fecha."</td>
				<td>".utf8_encode($Productos)."</td>
				<td>".$Cantidades."</td>
				<td>".$Total."</td>
				<td class='opc'><img src='../img/ok.png' onclick='AgregarCompra(\"".$id."\")' alt='Modificar' class='clickable'/></td>
			</tr>");
		}
		
	}	
?>
</table>