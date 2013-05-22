<table id='table-content'>
	<tr class='tr-headerv'>
		<th>Lote</th>
		<th>Producto</th>
		<th>Cantidad</th>
		<th>Total</th>
		<th colspan="2"></th>
		
	</tr>
<?php
	include("../php/DataConnection.class.php");
	include("../php/validations.class.php");
	//Inpaginacion
	$db = new DataConnection();
	
	if(isset($_GET['Folio'])){
		$numFolio = Validations::cleanString($_GET["Folio"]);
		$qry="SELECT a.folio, a.idlote, p.nombre, a.cantidad, a.cantidad*p.precio as 'Precio', a.estado FROM articuloventa a, producto p, lote l WHERE l.idProducto = p.idProducto AND l.idLote = a.idLote AND a.Folio =".$numFolio;
	    $result = $db->executeQuery($qry);	
	if ( mysql_num_rows($result) < 1){
		echo ("<tr class='tr-contv'>
			   <td colspan='4'><center>No se encontraron resultados</center></td>
			   </tr>");
	}else{	
		/* Agrega los resultados */
		while($fila = mysql_fetch_array($result))
		{
			$Lote = $fila['idlote'];
			$Producto = $fila['nombre'];	
			$Cantidad = $fila['cantidad'];
			$Precio = $fila['Precio'];
			$Estado= $fila['estado'];
			echo ("<tr class='tr-contv' id='".$Lote."' name='".$Lote."'>
				<td>".$Lote."</td>
				<td>".$Producto."</td>
				<td>".$Cantidad."</td>
				<td>".$Precio."</td>");
			if($_GET['view']!=1){
			if($fila['estado']!="Cancelado")
			{		
			echo ("<td colspan='2'><img src='../img/less.png'   onclick='cancelarArticulo(\"".$Lote."\")' alt='Eliminar' title='Eliminar' class='clickable'/></td>
			");}
			else{
				echo ("<td colspan='2'><img src='../img/cancelar.png' alt='Cancelar' title='Cancelado'/></td>
			");}}
			else{ echo "<td>".$Estado."</td>";}
			echo "</tr>";
		}
		}
		}
?></table>