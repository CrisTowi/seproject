<?php
	@header('Cache-Control: no-cache, no-store, must-revalidate');
?>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<table id='table-content'>
	<tr class='tr-header'>
		<td>N&uacute;mero de Lote</td>
		<td>Producto Asociado</td>
		<td>Unidades Producidas</td>                  
		<td>Fecha de Elaboraci&oacute;n</td>
		<!--<td>Fecha de Caducidad</td>  -->
        <td colspan="3">Opciones</td>      
		<!--<td class='opc'></td>
		<td class='opc'> </td>-->
	</tr>
<?php
	include("../php/DataConnection.class.php");
	include("../php/Validations.class.php");
	include("clases/Lote.class.php");		
	//Obtener Conexion
	$db = new DataConnection();	
	//Obtener todos los datos de la tabla lote
	$qry = "SELECT * FROM lote";
	
	// Añade parametros de búsqueda
	if ( isset($_GET["search"] ) ){ 
		$filtro = Validations::cleanString($_GET["search"]); // Limpia la entrada
		//Condicion para la busqueda
		$qry .= " WHERE idLote LIKE '%".$filtro."%'";
	}
	//echo $qry;
	//Ejecutar consulta
	$result = $db->executeQuery($qry);	
	
	if ( mysql_num_rows($result) < 1){
		echo ("<tr class='tr-cont'>
			<td colspan = '6'>No se encontraron resultados</td>
		</tr>");
	}else{	
		/* Agrega los resultados */
		while($fila = mysql_fetch_array($result)){		
			$nolote = $fila['idLote'];	
			$producto = $fila['idProducto'];
			$cantidad = $fila['cantidadProducto'];			
			$elaboracion = $fila['fecha_elaboracion'];
			//$caducidad = $fila['fecha_caducidad'];
/*
			$edo = utf8_encode($fila["estado"]);
			if($edo == "produccion"){
				$estado = "producción";
			}
			else{
				$estado = $edo;
			}
*/
			echo ("<tr class='tr-cont' id='".$nolote."' name='".$nolote."'>
				<td>".$nolote."</td>
				<td>".getCookieById($producto)."</td>
				<td>".$cantidad." paquetes</td>				
				<td>".$elaboracion."</td>
				<td>
				<img src='../img/pencil.png' onclick='modificarLote(\"".$nolote."\")' alt='Modificar' class='clickable'/>
				</td>
				<td>
				<img src='../img/less.png'   onclick='eliminarLote(\"".$nolote."\")' alt='Eliminar' class='clickable'/>
				</td>");

			$milote = Lote::findById($nolote);
			echo ("<td>
					<img src='../img/search.png'
					onclick='detalleLote(\"".$nolote."\", 
					\"".getCookieById($milote->getProducto())."\", 
					\"".$milote->getCantidad()."\",
					
					\"".$milote->getLinea()."\",					
					\"".getEncargado($milote->getEncargado())."\",															
					
					\"".$milote->getElaboracion()."\",
					\"".$milote->getCaducidad()."\")' 
					alt='Detalle de Lote' class='clickable' />
				</td>
			</tr>");			
		}
	}	
?>
</table>
<?php
	function getCookieById($id){
		$db = new DataConnection();
		$consulta = "SELECT * FROM producto
		WHERE idProducto = '".$id."';";
		$res = $db->executeQuery($consulta);
		if(mysql_num_rows($res) < 1){
			return "no hay";
		}		
		else{
			while($fila = @mysql_fetch_array($res)){
				$nombre = utf8_encode($fila["Nombre"]);
			}
			return $nombre;
		}
		return 0;
	}
	
	function getEncargado($CURP){
		$db = new DataConnection();
		$consulta = "SELECT * FROM empleado WHERE CURP = '$CURP'";
		$res = $db->executeQuery($consulta);
		if(mysql_num_rows($res) < 1){
			return "Encargado No Registrado";
		}
		else{
			while($fila = @mysql_fetch_array($res)){
				$nombre = $fila["Nombre"];
			}
			return $nombre;
		}
		return 0;
	}	
?>

