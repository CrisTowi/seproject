<?php
	@header('Cache-Control: no-cache, no-store, must-revalidate');
?>
<table id='table-content'>
	<tr class='tr-header'>
		<td>Folio del Pedido</td>   
		<td>Producto Asociado</td>  
        <td>Cantidad Requerida</td> 
		<td>Estado</td>
		<td colspan="2">Opciones</td>
	</tr>
<?php
	include("../php/DataConnection.class.php");
	include("../php/Validations.class.php");
	
	include("clases/Lote.class.php");	
	$db = new DataConnection();	
/*
	SELECT * 
	FROM  `articuloventa` a, venta v
	WHERE a.folio = v.folio
	AND v.estado !=  'cancelada'
*/
/*	
	$qry = "SELECT v.folio, a.idLote, cp.Nombre, a.estado
	FROM articuloventa a, venta v, lote l, producto cp 
	WHERE a.folio = v.folio AND v.estado != 'cancelada' AND a.idLote = l.idLote AND l.idProducto = cp.idProducto ";
*/
/*	
	$qry = "SELECT a.folio, a.idLote, p.Nombre, a.Estado
			FROM articuloventa a, producto p, lote l
			WHERE a.Estado != 'Cancelado' AND a.idLote = l.idLote AND l.idProducto = p.idProducto";
*/
	$qry = "SELECT a.folio, p.Nombre, a.cantidad, a.estado
			FROM articuloventa a, producto p
			WHERE a.estado = 'pendiente' and a.idProducto = p.idProducto";			
	// Añade parametros de búsqueda
	if ( isset($_GET["search"] ) ){ 
		$filtro = Validations::cleanString($_GET["search"]); // Limpia la entrada
		$qry .= " AND a.folio LIKE '%".$filtro."%'";
	}	
	
	$result = $db->executeQuery($qry);	
	
	if ( mysql_num_rows($result) < 1){
		echo ("<tr class='tr-cont'>
			<td colspan='5'>No se encontraron resultados</td>
		</tr>");	
	}else{
		while($fila = mysql_fetch_array($result)){		
			$folio = $fila["folio"];
			$prod = $fila['Nombre'];	
			$cant = utf8_encode($fila['cantidad']);				
			$edo = $fila['estado'];
		
/*			
			if($edo == "NULL"){
				$estado = "pendiente";
			}
			else{
				$estado = $edo;
			}			
*/			
			echo ("<tr class='tr-cont' id='".$folio."' name='".$folio."'>
				<td>VE-".$folio."</td>
				<td>".$prod."</td>
				<td>".$cant."</td>												
				<td>".$edo."</td>");
			//if($edo != "produccion"){
				echo ("<td>
					<img src='../img/notepad.png' 
					onclick='enviarProduccion(\"".$folio."\",\"".$prod."\",\"".$cant."\")' 
					alt='Producir' class='clickable'/></td>");
			//}
			//$milote = Lote::findById($idlote);
/*			echo ("<td>
					<img src='../img/search.png'
					onclick='detalleLote(\"".$idlote."\", 
					\"".$milote->getProducto()."\", 
					\"".$milote->getCantidad()."\",
					\"".$milote->getElaboracion()."\",
					\"".$milote->getCaducidad()."\")' 
					alt'Detalle de Lote' class='clickable' />
				</td>
			</tr>");				*/
		}		
	}
/*	

		

	}else{	
		// Agrega los resultados 
	}	
*/	
?>
</table>
<?php
	//Obtener el nombre del Empleado
	function obtenerNombre($CURP){
		include("../php/Empleado.class.php");	
		$empleado = Empleado::findById($CURP);
		$nombre = $empleado->getNombre();
		return $nombre;
	}

	function getCookieById($id){
		$db = new DataConnection();
		$consulta = "SELECT * FROM producto
		WHERE idProducto = '".$id."';";
		$res = $db->executeQuery($consulta);
		if(mysql_num_rows($res) < 1){
			return "Producto Inexistente";
		}		
		else{
			while($fila = @mysql_fetch_array($res)){
				$nombre = utf8_encode($fila["Nombre"]);
			}
			return $nombre;
		}
		return 0;
	}
?>
