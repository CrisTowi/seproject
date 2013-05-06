<?php header('Content-Type: text/html; charset=utf-8'); ?>
<table style="margin-left: 10px">
	<tr style='background-color:#333333; color: white;'>
		<td style="width: 100px;"><h2>Fecha</h2></td>
		<td style="width: 200px;"><h2>Remitente</h2></td>
		<td style="width: 270px;"><h2>Asunto</h2></td>
	</tr>
<?php	
	include("../DataConnection.class.php");	
	include("../AccessControl.php");	
	$db = new DataConnection();
	if ( isset($_GET["archivado"]) ){
		$flt = $_GET["archivado"];	
		$qry = "SELECT * FROM Mensajes,Empleado WHERE Mensajes.archivado = ".$flt." and Mensajes.remitente=Empleado.CURP and Mensajes.destinatario='".$sesion->getEmpleado()->getArea()."' ORDER BY id DESC";
		$read = "true";
	} else {
		$qry = "SELECT * FROM Mensajes,Empleado WHERE Mensajes.remitente='".$sesion->getEmpleado()->getCurp()."' and Mensajes.remitente=Empleado.CURP ORDER BY id DESC";
		$read = "false";
	}
	$result = $db->executeQuery($qry);
	$cont = 0;
	while($fila = mysql_fetch_array($result))
	{		
		$cont++;
		echo "<tr style='background-color:#DDDDDD;'>";
		echo "<td>".$fila["fecha"]."</td>";
		echo "<td>".$fila["Nombre"]."</td>";
		echo "<td>".$fila["asunto"]."</td>";
		echo "<td class='opc'><img src='../img/busc.png' onclick='viewDetails(".$fila["id"].",".$read.");' alt='Modificar'class='clickable'/></td>";
		echo "</tr>";
	}
	if ( $cont == 0 ){
		echo "<tr style='background-color:#DDDDDD;'>";
		echo "<td colspan='4'>No hay mensajes</td>";
		echo "</tr>";
	}
?>
</table>

