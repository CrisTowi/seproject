<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>		
        <title>Modulo de Producción</title>
        <link rel="stylesheet" type="text/css" href="../css/mainStyle.css" />
		<link rel="stylesheet" type="text/css" href="../css/jquery-ui.css">
	</head>
	<body>		
	
<?php
	include("../php/DataConnection.class.php");		
	$db = new DataConnection();
	
	$noLote = $_POST['noLote'];
	
	$query = "select l.idLote, l.noLinea, e.Nombre, p.Nombre, l.cantidadProducto, l.fecha_elaboracion, l.fecha_caducidad
			  from lote l, producto p, empleado e
			  where l.idProducto=p.idProducto
			  and l.curpEmpleado=e.CURP and l.idLote='$noLote'";			  
	
	$result = $db->executeQuery($query);	

	if (!$result) 
		die ("Database access failed: " . mysql_error());
		
	$row = mysql_fetch_row($result);
	
	echo '<table id="table-content" style="font-family: \'PT Sans\'; margin: 10px;">
		    <tr>
				<td class="tr-header">Numero de Lote</td>
				<td class="tr-cont">'.$noLote.'</td>
			</tr>
			<tr>
				<td class="tr-header">Linea de Produccion</td>
				<td class="tr-cont">'.$row[1].'</td>
			</tr>
			<tr>
				<td class="tr-header">Encargado</td>
				<td class="tr-cont">'.$row[2].'</td>
			</tr>
			<tr>
				<td class="tr-header">Producto elaborado</td>
				<td class="tr-cont">'.$row[3].'</td>
			</tr>
			<tr>
				<td class="tr-header">Unidades producidas</td>
				<td class="tr-cont">'.$row[4].'</td>
			</tr>
			<tr>
				<td class="tr-header">Fecha de elaboracion</td>
				<td class="tr-cont">'.$row[5].'</td>
			</tr>
			<tr>
				<td class="tr-header">Fecha de caducidad</td>
				<td class="tr-cont">'.$row[6].'</td>
			</tr>
		  </table>';
		  
	echo '<strong style="font-family: \'PT Sans\'; font-size: 13px;">Lotes de Materia Prima utilizados</strong>';
	
	$query = "select u.idLoteProduccion, m.nombre, u.idLoteMP, u.cantidadUsada, m.Unidad
			  from uso_mp u, materiaprima m, inventario_mp i
			  where u.idLoteMP=i.idLote
			  and i.idMateriaPrima=m.idMateriaPrima
			  and idLoteProduccion='$noLote'";			  
	
	$result = $db->executeQuery($query);	

	if (!$result) 
		die ("Database access failed: " . mysql_error());
		
	$rows = mysql_num_rows($result);
		
	echo '<table id="table-content" style="font-family: \'PT Sans\'; margin: 10px; font-size: 13px;">
		    <tr class="tr-header">				
				<td>Ingrediente</td>
				<td>Lote de MP utilizado</td>
				<td>Cantidad</td>
			</tr>';

	for ($j = 0 ; $j < $rows ; ++$j)
	{
		$row = mysql_fetch_row($result);
		echo '<tr class="tr-cont">
				<td>'.$row[1].'</td>
				<td>'.$row[2].'</td>
				<td>'.$row[3].' '.$row[4].'</td>
			</tr>';
	}
	
	echo	'</table>';
?>
	
</body>
</html>
<?php include("scripts.php"); ?>